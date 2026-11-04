<x-admin-layout title="Media library">
    <form class="admin-panel media-upload" method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <span class="icon-chip"><x-line-icon name="download" /></span>
        <div>
            <strong>Upload images or documents</strong>
            <small>JPG, PNG, WebP, GIF, PDF, Word, PowerPoint or ZIP. Up to 20 files, 20 MB each.</small>
        </div>
        <input class="admin-file" type="file" name="files[]" multiple required accept="image/jpeg,image/png,image/webp,image/gif,.pdf,.doc,.docx,.ppt,.pptx,.zip" aria-label="Files to upload">
        <button class="btn" type="submit">Upload <span class="btn-icon"><x-line-icon name="check" /></span></button>
    </form>
    <form class="admin-filters" method="GET">
        <select name="kind" onchange="this.form.submit()" aria-label="Filter by kind">
            <option value="">All files</option>
            <option value="images" @selected(request('kind') === 'images')>Images</option>
            <option value="documents" @selected(request('kind') === 'documents')>Documents</option>
        </select>
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search name or description" aria-label="Search">
        <button class="btn btn-plain btn-outline" type="submit">Search</button>
    </form>
    @if ($media->isEmpty())
        <section class="admin-panel"><p class="admin-empty">No files yet. Images the website ships with are still used until you replace them on a page.</p></section>
    @else
        <div class="library-grid">
            @foreach ($media as $file)
                <a class="library-card" href="{{ route('admin.media.edit', $file) }}">
                    <span class="library-thumb">@if ($file->isImage())<img src="{{ $file->url() }}" alt="" loading="lazy">@else<x-line-icon name="file" /><em>{{ strtoupper(pathinfo($file->filename, PATHINFO_EXTENSION)) }}</em>@endif</span>
                    <strong>{{ \Illuminate\Support\Str::limit($file->filename, 34) }}</strong>
                    <small>{{ $file->humanSize() }}@if ($file->isImage() && ! $file->alt) · <span class="library-warn">needs description</span>@endif</small>
                </a>
            @endforeach
        </div>
        {{ $media->links('partials.pager') }}
    @endif
</x-admin-layout>
