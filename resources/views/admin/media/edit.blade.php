<x-admin-layout title="Media" :heading="\Illuminate\Support\Str::limit($media->filename, 50)">
    <x-slot:actions><a class="link-arrow" href="{{ route('admin.media.index') }}">Media library <x-line-icon name="arrow" /></a></x-slot:actions>
    <div class="admin-form-grid">
        <section class="admin-panel media-detail">
            @if ($media->isImage())
                <img src="{{ $media->url() }}" alt="{{ $media->alt }}">
            @else
                <div class="media-detail-doc"><x-line-icon name="file" /><strong>{{ $media->filename }}</strong></div>
            @endif
            <dl class="admin-dl">
                <div><dt>Type</dt><dd>{{ $media->mime_type }}</dd></div>
                <div><dt>Size</dt><dd>{{ $media->humanSize() }}@if ($media->width) · {{ $media->width }} × {{ $media->height }} px @endif</dd></div>
                <div><dt>Uploaded</dt><dd>{{ $media->created_at->format('j M Y, H:i') }}</dd></div>
                <div><dt>Link</dt><dd><a href="{{ $media->url() }}" target="_blank" rel="noopener">{{ $media->url() }}</a></dd></div>
            </dl>
        </section>
        <aside class="admin-form-side">
            <form class="admin-panel form" method="POST" action="{{ route('admin.media.update', $media) }}">
                @csrf @method('PUT')
                <x-field name="alt" label="Description (alt text)" type="textarea" rows="3" :optional="! $media->isImage()" :value="$media->alt" hint="What the image shows, for screen readers and search engines." />
                <x-field name="caption" label="Caption or credit" optional :value="$media->caption" />
                <button class="btn" type="submit">Save <span class="btn-icon"><x-line-icon name="check" /></span></button>
            </form>
            <section class="admin-panel">
                <h2 class="admin-subhead">Where it is used</h2>
                @if ($usage)
                    <ul class="admin-usage">@foreach ($usage as $place)<li>{{ $place }}</li>@endforeach</ul>
                @else
                    <p class="admin-empty">Not used anywhere yet.</p>
                @endif
            </section>
        </aside>
    </div>
    <form class="admin-danger" method="POST" action="{{ route('admin.media.destroy', $media) }}" data-confirm="Delete this file permanently?">
        @csrf @method('DELETE')
        <button type="submit" @disabled($usage)>Delete file</button>
        @if ($usage)<small>Replace it where it is used before deleting.</small>@endif
    </form>
</x-admin-layout>
