<x-layouts.page :title="$case->title" :description="$case->category ? $case->category.' · '.$case->subtitle : $case->subtitle" og-type="article">
    @php
        $figure = null; $rest = $case->category;
        if ($case->category && preg_match('/^([\d.,]+\s?(?:%|\+)?)\s+(.+)$/u', $case->category, $m)) { [$figure, $rest] = [$m[1], $m[2]]; }
        [$org, $role] = array_pad(array_map('trim', explode('·', (string) $case->subtitle, 2)), 2, null);
        $minutes = max(2, (int) ceil(str_word_count(strip_tags((string) $case->body)) / 220));
    @endphp
    <article class="case">
        <header class="cs-hero">
            @if ($case->imageUrl())
                <figure class="cs-hero-img"><img src="{{ $case->imageUrl() }}" alt="{{ $case->imageAlt() }}"></figure>
            @endif
            <p class="cs-num" aria-hidden="true">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}</p>
            <div class="wrap cs-hero-inner">
                <div>
                    <a class="link-arrow cs-back" href="{{ route('work.index') }}"><x-line-icon name="arrow" /> All case studies</a>
                    <p class="eyebrow">Case study {{ str_pad($number, 2, '0', STR_PAD_LEFT) }} · {{ $org }}</p>
                    <h1 class="display cs-title">{{ $case->title }}</h1>
                </div>
                @if ($case->category)
                    <div class="cs-result {{ $figure ? '' : 'is-claim' }}">
                        <p>Headline result</p>
                        @if ($figure)<strong data-count="{{ $figure }}">{{ $figure }}</strong>@endif
                        <span>{{ $rest }}</span>
                    </div>
                @endif
            </div>
            <div class="wrap"><dl class="cs-meta">
                <div><dt>Organisation</dt><dd>{{ $org }}</dd></div>
                @if ($role)<div><dt>Her role</dt><dd>{{ $role }}</dd></div>@endif
                @if ($case->date)<div><dt>Date</dt><dd>{{ $case->date->format('F Y') }}</dd></div>@endif
                <div><dt>Reading time</dt><dd>{{ $minutes }} min</dd></div>
            </dl></div>
        </header>
        <div class="wrap case-body" id="story">
            <aside class="case-meta">
                <dl>
                    <div><dt>Organisation & role</dt><dd>{{ $case->subtitle }}</dd></div>
                    @if ($case->category)<div><dt>Headline result</dt><dd>{{ $case->category }}</dd></div>@endif
                    @if ($case->date)<div><dt>Date</dt><dd>{{ $case->date->format('F Y') }}</dd></div>@endif
                </dl>
                @if ($case->url)<a class="btn" href="{{ $case->url }}" target="_blank" rel="noopener noreferrer">Related link <span class="btn-icon"><x-line-icon name="arrow-up-right" /></span></a>@endif
            </aside>
            <div class="case-story prose">{{ block_text($case->body) }}</div>
        </div>
        @if ($next && ! $next->is($case))
            <a class="wrap case-next" href="{{ route('work.show', $next->slug) }}">
                <span class="eyebrow">Next case study</span>
                <span class="display h-lg">{{ $next->title }}</span>
                <span class="case-next-go"><x-line-icon name="arrow" /></span>
            </a>
        @endif
    </article>
    <x-site.cta title="Facing a similar challenge?" type="advisory" eyebrow="Work with Modupe" />
</x-layouts.page>
