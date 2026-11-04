<x-layouts.page :title="content('navigation.impact_label')" :description="content('impact.meta')">
    <section class="wrap page-hero">
        <div class="card card-mist-soft page-hero-copy" data-reveal>
            <p class="eyebrow">{{ content('impact.eyebrow') }}</p>
            <h1 class="display h-xl">{{ content_html('impact.title') }}</h1>
            <p class="lede">{{ content('impact.lede') }}</p>
        </div>
        <figure class="frame" data-reveal>
            <img src="{{ content_image('impact.image') }}" alt="">
            @if (content('impact.badge_title'))<div class="frame-badge"><x-line-icon name="star" /><div><strong>{{ content('impact.badge_title') }}</strong>{{ content('impact.badge_text') }}</div></div>@endif
        </figure>
    </section>

    <section class="wrap section">
        <div class="impact-orgs">
            @foreach (items('organisations') as $i => $org)
                <article class="card impact-org {{ ['card-navy card-glow', 'card-cream', 'card-white', 'card-mist-soft', 'card-sand'][$i % 5] }}" data-reveal>
                    <div class="impact-org-head">
                        @if ($org->imageUrl())
                            <span class="org-logo"><img src="{{ $org->imageUrl() }}" alt="{{ $org->imageAlt() ?: $org->title }}"></span>
                        @else
                            <span class="icon-chip"><x-line-icon :name="$org->icon ?: 'columns'" /></span>
                        @endif
                        <span class="idea-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <p class="impact-org-role">{{ $org->subtitle }}</p>
                    <h2 class="display h-sm">{{ $org->title }}</h2>
                    <p>{{ $org->body }}</p>
                    @if ($org->url)
                        <a class="link-arrow {{ $i % 5 === 0 ? 'link-arrow-light' : '' }}" href="{{ $org->url }}" target="_blank" rel="noopener noreferrer">Official website <x-line-icon name="arrow-up-right" /></a>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    @if (items('impact_focus')->isNotEmpty())
        <section class="wrap section-tight">
            <div class="split">
                <div class="sticky-col" data-reveal>
                    <p class="eyebrow">Focus areas</p>
                    <h2 class="display h-lg" style="margin-top: 18px">{{ content_html('impact.focus_title') }}</h2>
                </div>
                <ol class="list-lines" data-reveal>
                    @foreach (items('impact_focus') as $i => $line)
                        <li><span class="num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span><p>{{ $line->title }}</p></li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    <x-site.cta :title="content('impact.cta_title')" type="partnership" eyebrow="Collaborate" />
</x-layouts.page>
