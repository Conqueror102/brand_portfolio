<x-layouts.page :title="content('navigation.about_label')" :description="content('about.meta')">
    <section class="wrap page-hero">
        <div class="card card-cream page-hero-copy" data-reveal>
            <p class="eyebrow">{{ content('about.eyebrow') }}</p>
            <h1 class="display h-xl">{{ content_html('about.title') }}</h1>
            <p class="lede">{{ content('profile.short_bio') }}</p>
            <div class="actions">
                <a class="btn" href="{{ route('contact', ['type' => 'speaking']) }}">{{ content('speaking.cta_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                <a class="link-arrow" href="{{ route('insights.index') }}">Read the insights <x-line-icon name="arrow" /></a>
            </div>
        </div>
        <figure class="frame frame-portrait" data-reveal>
            <img src="{{ content_image('profile.portrait_second') }}" alt="{{ content('profile.portrait_alt') }}" width="1100" height="1429">
            @if (content('profile.portrait_note'))<figcaption class="frame-note">{{ content('profile.portrait_note') }}</figcaption>@endif
            @if (content('about.badge_title'))<div class="frame-badge"><x-line-icon name="columns" /><div><strong>{{ content('about.badge_title') }}</strong>{{ content('about.badge_text') }}</div></div>@endif
        </figure>
    </section>

    <section class="wrap section">
        <div class="split">
            <div class="sticky-col" data-reveal>
                <p class="eyebrow">Perspective</p>
                <h2 class="display h-lg" style="margin-top: 18px">{{ content_html('about.perspective_title') }}</h2>
            </div>
            <div class="prose-stack" data-reveal>
                @foreach (preg_split("/\R{2,}/", trim((string) content('profile.long_bio'))) as $i => $paragraph)
                    <p class="{{ $i === 0 ? 'lede' : 'body-copy' }}">{{ $paragraph }}</p>
                @endforeach
                <div class="idea-pair">
                    <div class="card card-mist-soft">
                        <span class="idea-num">01</span>
                        <h3 class="display h-sm">{{ content('about.idea1_title') }}</h3>
                        <p class="body-copy">{{ content('about.idea1_text') }}</p>
                    </div>
                    <div class="card card-sand">
                        <span class="idea-num">02</span>
                        <h3 class="display h-sm">{{ content('about.idea2_title') }}</h3>
                        <p class="body-copy">{{ content('about.idea2_text') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php($practice = items('practice'))
    @if (content_on('about.show_practice') && $practice->isNotEmpty())
        <section class="wrap section-tight practice" aria-labelledby="practice-title">
            <header class="section-head">
                <div>
                    <p class="eyebrow">{{ content('about.practice_eyebrow') }}</p>
                    <h2 id="practice-title" class="display h-lg">{{ content_html('about.practice_title') }}</h2>
                </div>
                @if (content('about.practice_text'))<p class="body-copy practice-intro">{{ content('about.practice_text') }}</p>@endif
            </header>
            <ol class="practice-list">
                @foreach ($practice as $i => $item)
                    <li class="practice-item" data-reveal>
                        <span class="practice-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div>
                            <h3>{{ $item->title }}</h3>
                            @if ($item->subtitle)<p class="practice-where">{{ $item->subtitle }}</p>@endif
                            <p class="body-copy">{{ $item->body }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>
    @endif

    @if (content_on('about.show_credentials') && items('credentials')->isNotEmpty())
        @php($groups = items('credentials')->groupBy(fn ($c) => $c->category === 'education' ? 'education' : 'development'))
        <section class="wrap section-tight" aria-labelledby="credentials-title">
            <header class="section-head">
                <div>
                    <p class="eyebrow">Education &amp; credentials</p>
                    <h2 id="credentials-title" class="display h-lg">{{ content_html('about.credentials_title') }}</h2>
                </div>
            </header>
            <div class="cred-columns" data-reveal>
                @foreach (['education' => content('about.education_label'), 'development' => content('about.development_label')] as $key => $label)
                    @if (($groups[$key] ?? collect())->isNotEmpty())
                        <div class="cred-col">
                            <h3 class="cred-col-title">{{ $label }}</h3>
                            <ul class="cred-list">
                                @foreach ($groups[$key] as $credential)
                                    <li><strong>{{ $credential->title }}</strong><span>{{ $credential->subtitle }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    @endif

    @if (content_on('about.show_roles') && items('organisations')->isNotEmpty())
        <section class="wrap section-tight">
            <div class="card card-navy card-glow roles-card" data-reveal>
                <div>
                    <p class="eyebrow">Current roles</p>
                    <h2 class="display h-lg" style="margin-top: 18px">{{ content_html('about.roles_title') }}</h2>
                    <a class="btn btn-light" style="margin-top: 34px" href="{{ route('impact') }}">{{ content('navigation.impact_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                </div>
                <ul class="roles-list">
                    @foreach (items('organisations') as $org)
                        <li><span class="roles-role">{{ $org->subtitle }}</span><strong>{{ $org->title }}</strong></li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @php($milestones = items('recognition'))
    @if (content_on('about.show_milestones') && $milestones->isNotEmpty())
        <section class="wrap section-tight" aria-labelledby="milestones-title">
            <header class="section-head">
                <div>
                    <p class="eyebrow">{{ content('about.milestones_eyebrow') }}</p>
                    <h2 id="milestones-title" class="display h-lg">{{ content_html('about.milestones_title') }}</h2>
                </div>
            </header>
            <ol class="milestones" data-reveal>
                @foreach ($milestones->reject(fn ($m) => str_contains((string) $m->title, 'to be added')) as $m)
                    <li><span class="milestone-year">{{ $m->category }}</span><strong>{{ $m->title }}</strong><span>{{ $m->subtitle }}</span></li>
                @endforeach
                <li class="milestone-next"><span class="milestone-year">{{ content('about.milestones_next_year') }}</span><strong>{{ content('about.milestones_next') }}</strong></li>
            </ol>
        </section>
    @endif

    @if (content('about.closing'))
        <section class="wrap section-tight">
            <blockquote class="about-closing" data-reveal><p>{{ content_html('about.closing') }}</p></blockquote>
        </section>
    @endif

    @if (content_on('about.show_links'))
        <section class="wrap section-tight">
            <div class="grid-3">
                <a class="card card-white link-card" href="{{ route('speaking') }}" data-reveal>
                    <span class="icon-chip"><x-line-icon name="mic" /></span>
                    <h3 class="display h-sm">{{ content('navigation.speaking_label') }}</h3>
                    <p class="body-copy">Talks, panels, workshops and leadership retreats.</p>
                    <span class="link-card-arrow"><x-line-icon name="arrow-up-right" /></span>
                </a>
                <a class="card card-cream link-card" href="{{ route('mentorship') }}" data-reveal>
                    <span class="icon-chip"><x-line-icon name="steps" /></span>
                    <h3 class="display h-sm">Mentorship</h3>
                    <p class="body-copy">{{ cohort('duration') }} from aspiration to results.</p>
                    <span class="link-card-arrow"><x-line-icon name="arrow-up-right" /></span>
                </a>
                @if (page_live('book'))
                    <a class="card card-mist link-card" href="{{ route('book') }}" data-reveal>
                        <span class="icon-chip"><x-line-icon name="book" /></span>
                        <h3 class="display h-sm">{{ content('navigation.book_label') }}</h3>
                        <p class="body-copy">{{ content('book.title') }}@if (content_on('book.show_release') && content('book.release')), {{ content('book.release') }}@endif.</p>
                        <span class="link-card-arrow"><x-line-icon name="arrow-up-right" /></span>
                    </a>
                @else
                    <a class="card card-mist link-card" href="{{ route('insights.index') }}" data-reveal>
                        <span class="icon-chip"><x-line-icon name="file" /></span>
                        <h3 class="display h-sm">{{ content('navigation.insights_label') }}</h3>
                        <p class="body-copy">Ideas on institutions, leadership and execution.</p>
                        <span class="link-card-arrow"><x-line-icon name="arrow-up-right" /></span>
                    </a>
                @endif
            </div>
        </section>
    @endif
</x-layouts.page>
