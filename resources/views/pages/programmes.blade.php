@php($status = mentorship_status())
<x-layouts.page :title="content('navigation.programmes_label')" :description="content('programmes.meta')">
    <section class="wrap page-hero-simple">
        <p class="eyebrow">{{ content('programmes.eyebrow') }}</p>
        <h1 class="display h-xl">{{ content_html('programmes.title') }}</h1>
        <p class="lede">{{ content('programmes.lede') }}</p>
    </section>

    <section class="wrap section-tight">
        <article class="programme-feature" data-reveal>
            <figure class="frame programme-feature-art">
                <img src="{{ content_image('programmes.feature_image') }}" alt="">
                <span class="status-pill status-{{ $status }} programme-status">{{ mentorship_status_label($status) }}</span>
            </figure>
            <div class="card card-cream programme-feature-body">
                <p class="eyebrow">Featured · Mentorship · {{ cohort('cohort') }}</p>
                <h2 class="display h-lg">The Mentorship <em>Programme.</em></h2>
                <p class="body-copy">{{ content('programmes.feature_text') }}</p>
                <dl class="facts">
                    <div><dt>Duration</dt><dd>{{ cohort('duration') }}</dd></div>
                    <div><dt>Investment</dt><dd>{{ cohort('fee') }}</dd></div>
                    <div><dt>Admission</dt><dd>Application</dd></div>
                </dl>
                <div class="actions">
                    <a class="btn" href="{{ route('mentorship') }}">Explore the programme <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                    @if ($status === 'open')<a class="link-arrow" href="{{ route('mentorship') }}#apply">Apply now <x-line-icon name="arrow" /></a>@endif
                </div>
            </div>
        </article>
    </section>

    @if (items('programmes')->isNotEmpty())
        <section class="wrap section-tight">
            <div class="grid-3">
                @foreach (items('programmes') as $i => $programme)
                    <article class="card feature-card programme-card {{ ['card-white', 'card-mist-soft', 'card-sand'][$i % 3] }}" data-reveal>
                        @if ($programme->imageUrl())<img class="programme-card-img" src="{{ $programme->imageUrl() }}" alt="{{ $programme->imageAlt() }}" loading="lazy">@endif
                        @if ($programme->category)<span class="status-pill status-{{ $programme->category === 'on_request' ? 'open' : $programme->category }}">{{ config('collections.programmes.categories.'.$programme->category) }}</span>@endif
                        <h3>{{ $programme->title }}</h3>
                        @if ($programme->subtitle)<p class="stat-label">{{ $programme->subtitle }}</p>@endif
                        <p>{{ $programme->body }}</p>
                        @if ($programme->url)<a class="link-arrow" href="{{ $programme->url }}">Find out more <x-line-icon name="arrow" /></a>@endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if (items('programme_principles')->isNotEmpty())
        <section class="wrap section-tight">
            <header class="section-head">
                <div>
                    <p class="eyebrow">Philosophy</p>
                    <h2 class="display h-lg">{{ content_html('programmes.principles_title') }}</h2>
                </div>
            </header>
            <div class="grid-3">
                @foreach (items('programme_principles') as $i => $principle)
                    <article class="card feature-card {{ ['card-mist-soft', 'card-sand', 'card-white'][$i % 3] }}" data-reveal>
                        <span class="icon-chip"><x-line-icon :name="$principle->icon ?: 'compass'" /></span>
                        <h3>{{ $principle->title }}</h3>
                        <p>{{ $principle->body }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if (content('programmes.more_title'))
        <section class="wrap section-tight">
            <div class="card card-white coming-card" data-reveal>
                <span class="icon-chip"><x-line-icon name="spark" /></span>
                <div>
                    <h2 class="display h-sm">{{ content('programmes.more_title') }}</h2>
                    <p class="body-copy">{{ content('programmes.more_text') }}</p>
                </div>
                <a class="btn btn-plain" href="{{ route('contact', ['type' => 'session']) }}">Request a session</a>
            </div>
        </section>
    @endif
</x-layouts.page>
