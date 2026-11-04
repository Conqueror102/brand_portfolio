<x-layouts.page :title="$episode->title" :description="\Illuminate\Support\Str::limit(strip_tags((string) $episode->body), 155)" og-type="article">
    <article class="wrap article-head">
        <a class="link-arrow back-link" href="{{ route('podcast.index') }}"><x-line-icon name="arrow" /> All episodes</a>
        <p class="insight-meta">@if ($episode->category)<span class="insight-tag">Episode {{ $episode->category }}</span>@endif @if ($episode->date)<span>{{ $episode->date->format('j F Y') }}</span>@endif</p>
        <h1 class="display h-xl">{{ $episode->title }}</h1>
        @if ($episode->subtitle)<p class="lede">With {{ $episode->subtitle }}</p>@endif
    </article>
    <div class="wrap article-layout">
        <div>
            @if ($episode->embedUrl())
                <div class="media-embed media-embed-lg"><iframe src="{{ $episode->embedUrl() }}" title="{{ $episode->title }}" allow="encrypted-media; picture-in-picture" allowfullscreen></iframe></div>
            @elseif ($episode->url)
                <a class="btn" href="{{ $episode->url }}" target="_blank" rel="noopener noreferrer">Listen to the episode <span class="btn-icon"><x-line-icon name="play" /></span></a>
            @endif
            <div class="prose article-body" style="margin-top: 40px">{{ block_text($episode->body) }}</div>
        </div>
        <aside class="article-aside">
            @if (items('podcast_platforms')->isNotEmpty())
                <div class="card card-cream">
                    <p class="stat-label">Listen on</p>
                    <div class="platform-list">
                        @foreach (items('podcast_platforms') as $platform)<a href="{{ $platform->url }}" target="_blank" rel="noopener noreferrer">{{ $platform->title }} <x-line-icon name="arrow-up-right" /></a>@endforeach
                    </div>
                </div>
            @endif
            <div class="card card-navy card-glow">
                <p class="eyebrow">Be a guest</p>
                <p style="margin-top: 12px">Guest and collaboration requests are reviewed personally.</p>
                <a class="btn btn-light" style="margin-top: 20px" href="{{ route('contact', ['type' => 'media']) }}">Get in touch <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            </div>
        </aside>
    </div>
</x-layouts.page>
