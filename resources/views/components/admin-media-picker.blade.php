@props(['name', 'upload', 'value' => null, 'library' => collect(), 'kind' => 'image', 'altName' => null])
{{-- Pick a file from the media library, upload a new one, or clear it. --}}
@php($id = 'mp-'.md5($name))
<div class="media-picker" data-media-picker>
    <div class="media-picker-current">
        @if ($value && $kind === 'image')
            <img src="{{ media_url($value) }}" alt="" data-preview>
        @elseif ($value)
            <span class="media-picker-file"><x-line-icon name="file" /> {{ basename($value) }}</span>
        @else
            <span class="media-picker-empty" data-preview-empty><x-line-icon :name="$kind === 'image' ? 'eye' : 'file'" /> Nothing selected</span>
        @endif
    </div>
    <div class="media-picker-actions">
        <details class="media-picker-library">
            <summary>Choose from library ({{ $library->count() }})</summary>
            <div class="media-picker-grid">
                <label class="media-option media-option-none"><input type="radio" name="{{ $name }}" value="" @checked(! $value)> <span>None</span></label>
                @if ($value && ! $library->contains('path', $value))
                    <label class="media-option"><input type="radio" name="{{ $name }}" value="{{ $value }}" checked>@if ($kind === 'image')<img src="{{ media_url($value) }}" alt="">@else<span>{{ basename($value) }}</span>@endif<small>Current</small></label>
                @endif
                @foreach ($library as $file)
                    <label class="media-option" title="{{ $file->filename }}"><input type="radio" name="{{ $name }}" value="{{ $file->path }}" @checked($value === $file->path)>@if ($file->isImage())<img src="{{ $file->url() }}" alt="" loading="lazy">@else<span><x-line-icon name="file" /> {{ \Illuminate\Support\Str::limit($file->filename, 22) }}</span>@endif<small>{{ $file->alt ? \Illuminate\Support\Str::limit($file->alt, 20) : 'No description' }}</small></label>
                @endforeach
            </div>
        </details>
        <label class="media-picker-upload">
            <span>Or upload new</span>
            <input class="admin-file" type="file" name="{{ $upload }}" accept="{{ $kind === 'image' ? 'image/jpeg,image/png,image/webp' : '.pdf,.doc,.docx,.ppt,.pptx,.zip,image/*' }}">
        </label>
        @if ($altName && $kind === 'image')
            <input class="media-picker-alt" type="text" name="{{ $altName }}" placeholder="Describe the new image (for screen readers)">
        @endif
    </div>
</div>
