@php
    $groups = items('resources')->whereNotIn('category', ['press', 'speaker'])->groupBy('category');
    $kinds = config('collections.resources.categories');
@endphp
<x-layouts.page :title="content('navigation.resources_label')" :description="content('resources.meta')">
    <section class="wrap page-hero-simple">
        <p class="eyebrow">{{ content('resources.eyebrow') }}</p>
        <h1 class="display h-xl">{{ content_html('resources.title') }}</h1>
        <p class="lede">{{ content('resources.lede') }}</p>
    </section>
    <section class="wrap section-tight">
        @forelse ($groups as $kind => $resources)
            <div class="resource-group">
                <h2 class="display h-sm">{{ $kinds[$kind] ?? 'Resources' }}</h2>
                <div class="grid-3">
                    @foreach ($resources as $resource)
                        @php($link = $resource->fileUrl() ?: $resource->url)
                        <article class="card card-white resource-card" data-reveal>
                            @if ($resource->imageUrl())<img src="{{ $resource->imageUrl() }}" alt="{{ $resource->imageAlt() }}" loading="lazy">@else<span class="icon-chip"><x-line-icon :name="$resource->file ? 'file' : 'arrow-up-right'" /></span>@endif
                            <h3>{{ $resource->title }}</h3>
                            @if ($resource->body)<p>{{ $resource->body }}</p>@endif
                            @if ($link)<a class="link-arrow" href="{{ $link }}" @if ($resource->file) download @else target="_blank" rel="noopener noreferrer" @endif>{{ $resource->file ? 'Download' : 'Open' }} <x-line-icon :name="$resource->file ? 'download' : 'arrow-up-right'" /></a>@endif
                        </article>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="empty-state card card-mist-soft">
                <span class="success-icon success-icon-muted"><x-line-icon name="download" /></span>
                <h2 class="display h-md">{{ content('resources.empty') }}</h2>
            </div>
        @endforelse
    </section>
</x-layouts.page>
