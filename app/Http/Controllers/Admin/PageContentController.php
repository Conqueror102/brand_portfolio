<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageContentController extends Controller
{
    public function index(): View
    {
        $drafts = Content::where('has_draft', true)->pluck('key')
            ->groupBy(fn (string $key) => explode('.', $key)[0])
            ->map->count();

        return view('admin.pages.index', ['groups' => config('content.groups'), 'drafts' => $drafts]);
    }

    public function edit(string $group): View
    {
        $definition = $this->group($group);
        $stored = Content::all_values();

        $values = [];
        foreach ($definition['fields'] as $name => $field) {
            $row = $stored[$group.'.'.$name] ?? null;
            $values[$name] = $row && $row['has_draft'] ? $row['draft'] : (($row['value'] ?? null) ?? $field['default']);
        }

        return view('admin.pages.edit', [
            'group' => $group,
            'definition' => $definition,
            'values' => $values,
            'hasDraft' => collect($stored)->filter(fn ($row, $key) => str_starts_with($key, $group.'.') && $row['has_draft'])->isNotEmpty(),
            'library' => Media::where('mime_type', 'like', 'image/%')->latest()->get(),
        ]);
    }

    public function update(Request $request, string $group): RedirectResponse
    {
        $definition = $this->group($group);
        $keys = array_map(fn ($name) => $group.'.'.$name, array_keys($definition['fields']));
        $action = $request->input('action', 'draft');

        if ($action === 'discard') {
            Content::discard($keys);

            return to_route('admin.pages.edit', $group)->with('status', 'Unpublished changes discarded.');
        }

        $values = $this->validated($request, $definition['fields']);
        Content::saveDraft(collect($values)->mapWithKeys(fn ($value, $name) => [$group.'.'.$name => $value])->all());

        if ($action === 'publish') {
            Content::publish($keys);

            return to_route('admin.pages.edit', $group)->with('status', 'Published. The changes are now live.');
        }

        if ($action === 'preview') {
            $url = $definition['preview'] ?? '/';

            return redirect($url.(str_contains($url, '?') ? '&' : '?').'preview=1');
        }

        return to_route('admin.pages.edit', $group)->with('status', 'Draft saved. Preview it, then publish when ready.');
    }

    /** @return array<string, mixed> */
    private function group(string $group): array
    {
        abort_unless($definition = config('content.groups.'.$group), 404);

        return $definition;
    }

    /**
     * @param  array<string, array<string, mixed>>  $fields
     * @return array<string, string|null>
     */
    private function validated(Request $request, array $fields): array
    {
        $rules = [];
        foreach ($fields as $name => $field) {
            $rules['fields.'.$name] = match ($field['type']) {
                'text', 'rich' => ['nullable', 'string', 'max:300'],
                'textarea', 'lines' => ['nullable', 'string', 'max:3000'],
                'longtext' => ['nullable', 'string', 'max:30000'],
                'link' => ['nullable', 'string', 'max:500', 'regex:~^(/|#|https?://|mailto:)~'],
                'image' => ['nullable', 'string', 'max:255'],
                'toggle' => ['nullable', 'boolean'],
                'sections' => ['nullable', 'array'],
                default => ['nullable', 'string'],
            };
            if ($field['type'] === 'image') {
                $rules['uploads.'.$name] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'];
            }
            if ($field['type'] === 'sections') {
                $rules['fields.'.$name.'.*.key'] = ['required', Rule::in(array_keys(config('content.home_sections')))];
                $rules['fields.'.$name.'.*.order'] = ['nullable', 'integer'];
                $rules['fields.'.$name.'.*.visible'] = ['nullable', 'boolean'];
            }
        }

        $data = Validator::make($request->all(), $rules, ['regex' => 'Links must start with /, #, https:// or mailto:.'], $this->attributes($fields))->validate();

        $values = [];
        foreach ($fields as $name => $field) {
            $value = $data['fields'][$name] ?? null;
            $values[$name] = match ($field['type']) {
                'toggle' => $request->boolean('fields.'.$name) ? '1' : '0',
                'sections' => collect($value ?? [])
                    ->sortBy(fn ($row) => (int) ($row['order'] ?? 0))
                    ->map(fn ($row) => $row['key'].':'.(! empty($row['visible']) ? '1' : '0'))
                    ->implode(','),
                'image' => $request->hasFile('uploads.'.$name)
                    ? Media::upload($request->file('uploads.'.$name), $request->input('upload_alt.'.$name))->path
                    : ($value ?? ''),
                default => $value === null ? '' : str_replace("\r\n", "\n", (string) $value),
            };
        }

        return $values;
    }

    /** @param array<string, array<string, mixed>> $fields @return array<string, string> */
    private function attributes(array $fields): array
    {
        $names = [];
        foreach ($fields as $name => $field) {
            $names['fields.'.$name] = strtolower($field['label']);
            $names['uploads.'.$name] = strtolower($field['label']);
        }

        return $names;
    }
}
