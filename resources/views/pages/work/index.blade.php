<x-layouts.page :title="content('navigation.work_label')" :description="content('work.meta')">
    @php
        $stats = items('proof_stats');
        $logos = items('affiliations')->filter(fn ($o) => $o->imageUrl());
        $split = function (?string $result) {
            if ($result && preg_match('/^([\d.,]+\s?(?:%|\+)?)\s+(.+)$/u', $result, $m)) return [$m[1], $m[2]];
            return [null, $result];
        };
    @endphp

    {{-- Opening: the blueprint draws itself in behind a loud statement; the results roll on the right. --}}
    <section class="wk-hero" data-wk-hero>
        @if (content_image('work.hero_art'))
            <div class="wk-art" aria-hidden="true">
                <img src="{{ content_image('work.hero_art') }}" alt="">
                <i class="wk-scan"></i>
                <i class="wk-lens" data-wk-lens></i>
            </div>
        @endif
        <div class="wrap wk-hero-inner">
            <div class="wk-copy">
                <p class="eyebrow">{{ content('work.eyebrow') }}</p>
                <h1 class="display wk-title" data-wk-title>{{ content_html('work.title') }}</h1>
                <p class="wk-lede">{{ content('work.lede') }}</p>
                <div class="actions">
                    <a class="btn wk-btn" href="#case-files">{{ content('work.primary_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                    <a class="link-arrow wk-link" href="{{ route('contact') }}?type=advisory">Start a conversation <x-line-icon name="arrow" /></a>
                </div>
            </div>

            @if ($stats->isNotEmpty())
                <aside class="wk-ticker" data-wk-ticker aria-label="{{ content('work.results_label') }}">
                    <p class="wk-ticker-label"><span>{{ content('work.results_label') }}</span><span class="wk-ticker-count"><b data-wk-index>01</b> / {{ str_pad($stats->count(), 2, '0', STR_PAD_LEFT) }}</span></p>
                    <div class="wk-ticker-stage">
                        @foreach ($stats as $stat)
                            <div class="wk-stat {{ $loop->first ? 'is-on' : '' }}" data-wk-stat>
                                <strong>{{ $stat->title }}</strong>
                                <p>{{ $stat->subtitle }}</p>
                                @if ($stat->body)<span>{{ $stat->body }}</span>@endif
                            </div>
                        @endforeach
                    </div>
                    <div class="wk-ticker-bars" aria-hidden="true">@foreach ($stats as $stat)<i class="{{ $loop->first ? 'is-on' : '' }}" data-wk-bar><b></b></i>@endforeach</div>
                </aside>
            @endif
        </div>

        @if ($logos->isNotEmpty())
            <div class="wk-logos" aria-label="{{ content('work.logos_label') }}">
                <p>{{ content('work.logos_label') }}</p>
                <div class="wk-logos-track">
                    @foreach ([0, 1] as $copy)
                        <ul @if ($copy) aria-hidden="true" @endif>
                            @foreach ($logos as $org)<li><img src="{{ $org->imageUrl() }}" alt="{{ $copy ? '' : $org->title }}" loading="lazy"></li>@endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    {{-- The case files: one editorial spread per story. --}}
    <section class="wk-files" id="case-files" aria-labelledby="files-title">
        <header class="wrap wk-files-head">
            <p class="eyebrow">{{ content('work.list_eyebrow') }}</p>
            <h2 id="files-title" class="display h-xl">{{ content_html('work.list_title') }}</h2>
        </header>
        <ol class="wk-list">
            @foreach ($cases as $case)
                @php([$figure, $rest] = $split($case->category))
                <li class="wk-case {{ $loop->even ? 'is-flip' : '' }}" data-wk-case>
                    <a class="wrap wk-case-link" href="{{ route('work.show', $case->slug) }}">
                        <span class="wk-case-num" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <figure class="wk-case-img">
                            @if ($case->imageUrl())<img src="{{ $case->imageUrl() }}" alt="" loading="lazy">@endif
                        </figure>
                        <div class="wk-case-copy">
                            <p class="wk-case-org">{{ $case->subtitle }}</p>
                            @if ($figure)
                                <p class="wk-case-figure"><strong data-count="{{ $figure }}">{{ $figure }}</strong><span>{{ $rest }}</span></p>
                            @elseif ($rest)
                                <p class="wk-case-claim">{{ $rest }}</p>
                            @endif
                            <h3 class="wk-case-title">{{ $case->title }}</h3>
                            <span class="wk-case-read">{{ content('work.read_label') }} <span class="wk-case-go"><x-line-icon name="arrow" /></span></span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ol>
    </section>

    <x-site.cta :title="content('work.cta_title')" type="advisory" eyebrow="Work with Modupe" />
</x-layouts.page>
