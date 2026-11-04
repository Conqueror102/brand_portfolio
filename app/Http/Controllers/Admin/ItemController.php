<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function overview(): View
    {
        $counts = Item::selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type');

        return view('admin.items.overview', [
            'groups' => collect($this->types())->groupBy('group', preserveKeys: true),
            'counts' => $counts,
        ]);
    }

    public function index(string $type): View
    {
        return view('admin.items.index', [
            'type' => $type,
            'definition' => $this->definition($type),
            'items' => Item::ofType($type)->get(),
        ]);
    }

    public function create(string $type): View
    {
        return $this->form($type, new Item(['type' => $type, 'is_published' => true]));
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $data = $this->validated($request, $type);
        $data['sort_order'] = (int) Item::where('type', $type)->max('sort_order') + 1;
        Item::create($data + ['type' => $type]);

        return to_route('admin.items.index', $type)->with('status', 'Added.');
    }

    public function edit(string $type, Item $item): View
    {
        abort_unless($item->type === $type, 404);

        return $this->form($type, $item);
    }

    public function update(Request $request, string $type, Item $item): RedirectResponse
    {
        abort_unless($item->type === $type, 404);
        $item->update($this->validated($request, $type));

        return to_route('admin.items.index', $type)->with('status', 'Saved.');
    }

    public function destroy(string $type, Item $item): RedirectResponse
    {
        abort_unless($item->type === $type, 404);
        $item->delete();

        return to_route('admin.items.index', $type)->with('status', 'Deleted.');
    }

    public function move(Request $request, string $type, Item $item): RedirectResponse
    {
        abort_unless($item->type === $type, 404);
        $items = Item::ofType($type)->get()->values();
        $index = $items->search(fn (Item $i) => $i->is($item));
        $swap = $items->get($request->input('direction') === 'up' ? $index - 1 : $index + 1);

        if ($swap) {
            // Re-number everything so orders are always distinct, then swap the pair.
            $items->each(fn (Item $i, int $position) => $i->updateQuietly(['sort_order' => $position]));
            $a = $item->fresh();
            $b = $swap->fresh();
            [$aOrder, $bOrder] = [$a->sort_order, $b->sort_order];
            $a->updateQuietly(['sort_order' => $bOrder]);
            $b->updateQuietly(['sort_order' => $aOrder]);
        }

        return to_route('admin.items.index', $type);
    }

    private function form(string $type, Item $item): View
    {
        return view('admin.items.form', [
            'type' => $type,
            'definition' => $this->definition($type),
            'item' => $item,
            'images' => Media::where('mime_type', 'like', 'image/%')->latest()->get(),
            'files' => Media::latest()->get(),
        ]);
    }

    /** @return array<string, array<string, mixed>> */
    private function types(): array
    {
        return Arr::except(config('collections'), 'icons');
    }

    /** @return array<string, mixed> */
    private function definition(string $type): array
    {
        abort_unless($definition = $this->types()[$type] ?? null, 404);

        return $definition;
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, string $type): array
    {
        $definition = $this->definition($type);
        $fields = $definition['fields'];
        $rules = ['is_published' => ['nullable', 'boolean']];
        $all = [
            'title' => ['required', 'string', 'max:300'],
            'subtitle' => ['nullable', 'string', 'max:300'],
            'body' => [array_key_exists('title', $fields) ? 'nullable' : 'required', 'string', 'max:30000'],
            'icon' => ['nullable', Rule::in(config('collections.icons'))],
            'image' => ['nullable', 'string', 'max:255'],
            'file' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:500', 'regex:~^(/|https?://)~'],
            'date' => ['nullable', 'date'],
            'category' => isset($definition['categories']) ? ['nullable', Rule::in(array_keys($definition['categories']))] : ['nullable', 'string', 'max:60'],
        ];
        foreach (array_keys($fields) as $field) {
            $rules[$field] = $all[$field];
        }
        if (isset($fields['image'])) {
            $rules['image_upload'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'];
        }
        if (isset($fields['file'])) {
            $rules['file_upload'] = ['nullable', 'file', 'mimes:'.implode(',', [...Media::DOCUMENT_TYPES, ...Media::IMAGE_TYPES]), 'max:20480'];
        }
        foreach ($definition['required'] ?? [] as $field) {
            $rules[$field] = ['required_without:'.$field.'_upload', 'nullable', 'string', 'max:255'];
        }
        if (! isset($fields['title'])) {
            $rules['title'] = ['nullable'];
        }

        $data = $request->validate($rules, ['url.regex' => 'Links must start with / or https://.', 'image.required_without' => 'Choose or upload a photo.'], ['url' => 'link']);

        if ($request->hasFile('image_upload')) {
            $data['image'] = Media::upload($request->file('image_upload'), $request->input('image_alt'))->path;
        }
        if ($request->hasFile('file_upload')) {
            $data['file'] = Media::upload($request->file('file_upload'))->path;
        }
        unset($data['image_upload'], $data['file_upload']);

        $data['title'] = $data['title'] ?? mb_substr((string) ($data['body'] ?? ''), 0, 80);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
