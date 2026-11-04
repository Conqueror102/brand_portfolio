<x-layouts.page :title="$case->title" :description="$case->category ? $case->category.' · '.$case->subtitle : $case->subtitle" og-type="article">
    <article class="case">
        <header class="wrap case-hero">
            <a class="case-back link-arrow" href="{{ route('work.index') }}"><x-line-icon name="arrow" /> Selected work</a>
            <p class="case-num" aria-hidden="true">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="eyebrow">{{ $case->subtitle }}</p>
            <h1 class="display h-xxl">{{ $case->title }}</h1>
            @if ($case->category)<p class="case-result"><span class="pulse-dot" aria-hidden="true"></span>{{ $case->category }}</p>@endif
        </header>
        @if ($case->imageUrl())
            <figure class="wrap case-figure" data-reveal="wipe-left"><img src="{{ $case->imageUrl() }}" alt="{{ $case->imageAlt() }}" data-parallax></figure>
        @endif
        <div class="wrap case-body">
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
