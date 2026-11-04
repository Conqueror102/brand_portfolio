@php($f = $definition['fields'])
<x-admin-layout :title="($item->exists ? 'Edit' : 'Add').' · '.$definition['label']" :heading="$item->exists ? \Illuminate\Support\Str::limit($item->title, 60) : 'Add to '.$definition['label']">
    <x-slot:actions><a class="link-arrow" href="{{ route('admin.items.index', $type) }}">{{ $definition['label'] }} <x-line-icon name="arrow" /></a></x-slot:actions>
    <form class="admin-form-grid" method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.items.update', [$type, $item->id]) : route('admin.items.store', $type) }}">
        @csrf
        @if ($item->exists) @method('PUT') @endif
        <section class="admin-panel form">
            @isset($f['title'])
                @if (mb_strlen((string) $item->title) > 120 || $type === 'speaking_audiences' || $type === 'mentorship_audience')
                    <x-field name="title" :label="$f['title']" type="textarea" :value="$item->title" required maxlength="300" />
                @else
                    <x-field name="title" :label="$f['title']" :value="$item->title" required maxlength="300" />
                @endif
            @endisset
            @isset($f['subtitle'])<x-field name="subtitle" :label="$f['subtitle']" optional :value="$item->subtitle" maxlength="300" />@endisset
            @isset($f['body'])
                <x-field name="body" :label="$f['body']" type="textarea" :optional="isset($f['title'])" :value="$item->body" rows="6" />
            @endisset
            @isset($f['url'])<x-field name="url" :label="$f['url']" optional :value="$item->url" placeholder="https://…" />@endisset
            @isset($f['file'])
                <div class="field">
                    <span>{{ $f['file'] }} <em>optional</em></span>
                    <x-admin-media-picker name="file" upload="file_upload" :value="old('file', $item->file)" :library="$files" kind="file" />
                    @error('file_upload')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            @endisset
        </section>
        <aside class="admin-form-side">
            <section class="admin-panel form">
                @isset($f['category'])
                    @if (isset($definition['categories']))
                        <label class="field"><span>{{ $f['category'] }}</span>
                            <select name="category">
                                @foreach ($definition['categories'] as $value => $label)<option value="{{ $value }}" @selected(old('category', $item->category) === $value)>{{ $label }}</option>@endforeach
                            </select>
                        </label>
                    @else
                        <x-field name="category" :label="$f['category']" optional :value="$item->category" />
                    @endif
                @endisset
                @isset($f['date'])<x-field name="date" :label="$f['date']" type="date" optional :value="$item->date?->format('Y-m-d')" />@endisset
                @isset($f['icon'])
                    <fieldset class="field icon-picker">
                        <legend>{{ $f['icon'] }}</legend>
                        <div class="icon-picker-grid">
                            @foreach (config('collections.icons') as $icon)
                                <label title="{{ $icon }}"><input type="radio" name="icon" value="{{ $icon }}" @checked(old('icon', $item->icon) === $icon)><span><x-line-icon :name="$icon" /></span></label>
                            @endforeach
                        </div>
                    </fieldset>
                @endisset
                <label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item->is_published))> <span>Visible on the website</span></label>
                <button class="btn" type="submit">{{ $item->exists ? 'Save changes' : 'Add' }} <span class="btn-icon"><x-line-icon name="check" /></span></button>
            </section>
            @isset($f['image'])
                <section class="admin-panel form">
                    <div class="field">
                        <span>{{ $f['image'] }} <em>optional</em></span>
                        <x-admin-media-picker name="image" upload="image_upload" alt-name="image_alt" :value="old('image', $item->image)" :library="$images" />
                        @error('image_upload')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </section>
            @endisset
        </aside>
    </form>
    @if ($item->exists)
        <form class="admin-danger" method="POST" action="{{ route('admin.items.destroy', [$type, $item->id]) }}" data-confirm="Delete this item? This cannot be undone.">
            @csrf @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    @endif
</x-admin-layout>
