@php
    $appearances = items('media_items')->sortByDesc(fn ($item) => $item->date?->timestamp ?? 0);
    $types = config('collections.media_items.categories');
    $press = items('resources')->where('category', 'press');
@endphp
<x-layouts.page :title="content('navigation.media_label')" :description="content('media.meta')">
    <section class="wrap page-hero-simple">
        <p class="eyebrow">{{ content('media.eyebrow') }}</p>
        <h1 class="display h-xl">{{ content_html('media.title') }}</h1>
        <p class="lede">{{ content('media.lede') }}</p>
    </section>

    @if ($appearances->isEmpty())
        <section class="wrap section-tight">
            <div class="grid-4">
                @foreach ([['mic', 'Speaking', 'Keynotes and panel appearances'], ['headphones', 'Podcasts', 'Long-form conversations'], ['video', 'Video', 'Recorded sessions and interviews'], ['file', 'Publications', 'Articles and features']] as $i => [$icon, $title, $text])
                    <article class="card feature-card media-type {{ ['card-white', 'card-cream', 'card-mist-soft', 'card-sand'][$i] }}" data-reveal>
                        <span class="icon-chip"><x-line-icon :name="$icon" /></span>
                        <h2>{{ $title }}</h2>
                        <p>{{ $text }}</p>
                    </article>
                @endforeach
            </div>
        </section>
        <section class="wrap section-tight">
            <div class="empty-state card card-mist-soft" data-reveal>
                <span class="success-icon success-icon-muted"><x-line-icon name="play" /></span>
                <h2 class="display h-md">{{ content('media.empty_title') }}</h2>
                <p class="body-copy">For interview or podcast requests, get in touch.</p>
                <a class="btn" href="{{ route('contact', ['type' => 'media']) }}">Request an interview <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            </div>
        </section>
    @else
        <section class="wrap section-tight">
            <nav class="tags media-filter" aria-label="Filter by type">
                <button type="button" class="tag is-active" data-filter="">All</button>
                @foreach ($types as $key => $label)
                    @if ($appearances->contains('category', $key))<button type="button" class="tag" data-filter="{{ $key }}">{{ $label }}</button>@endif
                @endforeach
            </nav>
            <div class="article-grid media-grid">
                @foreach ($appearances as $item)
                    <article class="article-card media-card" data-type="{{ $item->category }}" data-reveal>
                        @if ($item->embedUrl())
                            <div class="media-embed"><iframe src="{{ $item->embedUrl() }}" title="{{ $item->title }}" loading="lazy" allow="encrypted-media; picture-in-picture" allowfullscreen></iframe></div>
                        @else
                            <span class="article-card-art" @if ($item->imageUrl()) style="background-image: url('{{ $item->imageUrl() }}')" @endif><span class="media-type-badge"><x-line-icon :name="['interview' => 'mic', 'speaking' => 'panel', 'video' => 'play', 'podcast' => 'headphones', 'publication' => 'file'][$item->category] ?? 'play'" /></span></span>
                        @endif
                        <span class="article-card-body">
                            <span class="insight-meta"><span class="insight-tag">{{ $types[$item->category] ?? 'Media' }}</span>@if ($item->date)<span>{{ $item->date->format('j M Y') }}</span>@endif</span>
                            <span class="article-card-title">{{ $item->title }}</span>
                            @if ($item->subtitle)<span class="stat-label">{{ $item->subtitle }}</span>@endif
                            @if ($item->body)<span class="article-card-excerpt">{{ $item->body }}</span>@endif
                            @if ($item->url && ! $item->embedUrl())<a class="link-arrow" href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">Watch or read <x-line-icon name="arrow-up-right" /></a>@endif
                        </span>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="wrap section-tight">
        @if ($press->isNotEmpty())
            @include('partials.downloads', ['title' => 'Press kit', 'resources' => $press])
        @else
            <div class="card card-navy card-glow press-kit" data-reveal>
                <div>
                    <p class="eyebrow">Press kit</p>
                    <h2 class="display h-md" style="margin-top: 16px; color: #F4F1EC">{{ content('media.press_title') }}</h2>
                    <p style="margin-top: 14px">{{ content('media.press_text') }}</p>
                </div>
                <a class="btn btn-light" href="{{ route('contact', ['type' => 'media']) }}">Request the press kit <span class="btn-icon"><x-line-icon name="download" /></span></a>
            </div>
        @endif
    </section>
</x-layouts.page>
