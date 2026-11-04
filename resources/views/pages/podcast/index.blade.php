@php($episodes = items('podcast_episodes')->sortByDesc(fn ($e) => $e->date?->timestamp ?? $e->id))
<x-layouts.page :title="content('navigation.podcast_label')" :description="content('podcast.meta')">
    <section class="wrap section-tight">
        <div class="podcast-hero card card-navy card-glow" data-reveal>
            <div class="podcast-art">
                @if (content_image('podcast.artwork'))<img src="{{ content_image('podcast.artwork') }}" alt="">@else<span><x-line-icon name="headphones" /></span>@endif
            </div>
            <div>
                <p class="eyebrow">{{ content('podcast.eyebrow') }}</p>
                <h1 class="display h-xl" style="color: #F4F1EC; margin-top: 18px">{{ content_html('podcast.title') }}</h1>
                <p class="lede" style="color: #C9D0D7; margin-top: 18px">{{ content('podcast.lede') }}</p>
                @if (items('podcast_platforms')->isNotEmpty())
                    <div class="platforms">
                        @foreach (items('podcast_platforms') as $platform)
                            <a class="btn btn-light btn-plain" href="{{ $platform->url }}" target="_blank" rel="noopener noreferrer"><x-line-icon name="play" /> {{ $platform->title }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section class="wrap section-tight">
        @if ($episodes->isEmpty())
            <div class="empty-state card card-mist-soft">
                <span class="success-icon success-icon-muted"><x-line-icon name="headphones" /></span>
                <h2 class="display h-md">{{ content('podcast.empty') }}</h2>
                <a class="link-arrow" href="{{ route('contact', ['type' => 'media']) }}">Suggest a guest or collaboration <x-line-icon name="arrow" /></a>
            </div>
        @else
            <ol class="episode-list">
                @foreach ($episodes as $episode)
                    <li data-reveal>
                        <a class="episode" href="{{ route('podcast.show', $episode) }}">
                            <span class="episode-art" @if ($episode->imageUrl()) style="background-image: url('{{ $episode->imageUrl() }}')" @endif>@unless ($episode->imageUrl())<x-line-icon name="play" />@endunless</span>
                            <span class="episode-body">
                                <span class="insight-meta">@if ($episode->category)<span class="insight-tag">Episode {{ $episode->category }}</span>@endif @if ($episode->date)<span>{{ $episode->date->format('j M Y') }}</span>@endif</span>
                                <span class="article-card-title">{{ $episode->title }}</span>
                                @if ($episode->subtitle)<span class="stat-label">With {{ $episode->subtitle }}</span>@endif
                            </span>
                            <span class="insight-arrow"><x-line-icon name="arrow" /></span>
                        </a>
                    </li>
                @endforeach
            </ol>
        @endif
    </section>
</x-layouts.page>
