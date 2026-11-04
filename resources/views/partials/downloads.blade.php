<div class="card card-mist-soft downloads" data-reveal>
    <p class="eyebrow">{{ $title }}</p>
    <ul class="download-list">
        @foreach ($resources as $resource)
            @php($link = $resource->fileUrl() ?: $resource->url)
            <li>
                <span class="icon-chip"><x-line-icon :name="$resource->file ? 'download' : 'arrow-up-right'" /></span>
                <div><strong>{{ $resource->title }}</strong>@if ($resource->body)<span>{{ $resource->body }}</span>@endif</div>
                @if ($link)<a class="btn btn-plain btn-outline" href="{{ $link }}" @if ($resource->file) download @else target="_blank" rel="noopener noreferrer" @endif>{{ $resource->file ? 'Download' : 'Open' }}</a>@endif
            </li>
        @endforeach
    </ul>
</div>
