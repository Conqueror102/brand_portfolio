<x-admin-layout :title="$definition['label']">
    <x-slot:actions>
        <a class="link-arrow" href="{{ route('admin.pages.index') }}">All pages <x-line-icon name="arrow" /></a>
        <a class="link-arrow" href="{{ url($definition['preview']) }}" target="_blank" rel="noopener">View live page <x-line-icon name="arrow-up-right" /></a>
    </x-slot:actions>
    <p class="admin-intro">{{ $definition['description'] }}</p>
    @if ($hasDraft)
        <div class="alert alert-info admin-flash"><x-line-icon name="eye" /> <span>This page has unpublished changes. Visitors still see the live version until you publish.</span></div>
    @endif
    <form id="page-form" class="admin-content-form" method="POST" action="{{ route('admin.pages.update', $group) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @foreach (collect($definition['fields'])->groupBy(fn ($f) => $f['section'] ?? 'Content', preserveKeys: true) as $section => $fields)
            <section class="admin-panel form">
                <header><h2>{{ $section }}</h2></header>
                @foreach ($fields as $name => $field)
                    @php($value = old('fields.'.$name, $values[$name]))
                    @switch($field['type'])
                        @case('toggle')
                            <input type="hidden" name="fields[{{ $name }}]" value="0">
                            <label class="check switch"><input type="checkbox" name="fields[{{ $name }}]" value="1" @checked(filter_var($value, FILTER_VALIDATE_BOOLEAN))> <span>{{ $field['label'] }}</span></label>
                            @break
                        @case('image')
                            <div class="field">
                                <span>{{ $field['label'] }}</span>
                                <x-admin-media-picker :name="'fields['.$name.']'" :upload="'uploads['.$name.']'" :alt-name="'upload_alt['.$name.']'" :value="$value" :library="$library" />
                                @if ($field['hint'])<small class="field-hint">{{ $field['hint'] }}</small>@endif
                                @error('uploads.'.$name)<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            @break
                        @case('sections')
                            <div class="field">
                                <span>{{ $field['label'] }}</span>
                                <ol class="section-order" data-sortable>
                                    @php($rows = collect(explode(',', (string) $value))->map(fn ($e) => array_pad(explode(':', $e), 2, '1'))->filter(fn ($r) => isset(config('content.home_sections')[$r[0]]))->unique(0)->values())
                                    @foreach (array_keys(config('content.home_sections')) as $known)@if (! $rows->contains(0, $known))@php($rows->push([$known, '1']))@endif @endforeach
                                    @foreach ($rows as $i => [$key, $visible])
                                        <li>
                                            <input type="hidden" name="fields[{{ $name }}][{{ $i }}][key]" value="{{ $key }}">
                                            <input class="section-order-num" type="number" name="fields[{{ $name }}][{{ $i }}][order]" value="{{ $i + 1 }}" min="1" aria-label="Position of {{ config('content.home_sections')[$key] }}">
                                            <strong>{{ config('content.home_sections')[$key] }}</strong>
                                            <span class="section-order-move"><button type="button" data-move="up" aria-label="Move up">↑</button><button type="button" data-move="down" aria-label="Move down">↓</button></span>
                                            <label class="check"><input type="checkbox" name="fields[{{ $name }}][{{ $i }}][visible]" value="1" @checked($visible === '1')> <span>Show</span></label>
                                        </li>
                                    @endforeach
                                </ol>
                                <small class="field-hint">The hero always comes first. Use the arrows to reorder; untick to hide a section.</small>
                            </div>
                            @break
                        @default
                            <label class="field">
                                <span>{{ $field['label'] }}@if ($field['type'] === 'rich')<em>*word* = italic accent</em>@endif @if ($field['type'] === 'lines')<em>one per line</em>@endif</span>
                                @if (in_array($field['type'], ['textarea', 'longtext', 'lines']))
                                    <textarea name="fields[{{ $name }}]" rows="{{ $field['type'] === 'longtext' ? 10 : 3 }}" @error('fields.'.$name) aria-invalid="true" @enderror>{{ $value }}</textarea>
                                @else
                                    <input type="text" name="fields[{{ $name }}]" value="{{ $value }}" @if ($field['type'] === 'link') placeholder="/contact or https://…" list="site-links" @endif @error('fields.'.$name) aria-invalid="true" @enderror>
                                @endif
                                @if ($field['hint'])<small class="field-hint">{{ $field['hint'] }}</small>@endif
                                @if ($field['type'] === 'longtext')<small class="field-hint">Blank line between paragraphs. Start a line with “## ” for a heading.</small>@endif
                                @error('fields.'.$name)<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                    @endswitch
                @endforeach
            </section>
        @endforeach
        <datalist id="site-links">
            @foreach (['/', '/about', '/insights', '/speaking', '/programmes', '/programmes/mentorship', '/programmes/mentorship#apply', '/leadership-impact', '/media', '/book', '/book#waitlist', '/podcast', '/resources', '/contact', '/contact?type=speaking', '/contact?type=session', '/contact?type=mentorship', '/contact?type=media', '#insights'] as $link)<option value="{{ $link }}">@endforeach
        </datalist>
        <div class="admin-savebar">
            <button class="btn btn-plain btn-outline" type="submit" name="action" value="draft">Save draft</button>
            <button class="btn btn-plain btn-outline" type="submit" name="action" value="preview" formtarget="_blank"><x-line-icon name="eye" /> Preview</button>
            <button class="btn" type="submit" name="action" value="publish">Publish <span class="btn-icon"><x-line-icon name="check" /></span></button>
            @if ($hasDraft)<button class="admin-link-danger" type="submit" name="action" value="discard" formnovalidate data-confirm-click="Discard all unpublished changes on this page?">Discard changes</button>@endif
        </div>
    </form>
</x-admin-layout>
