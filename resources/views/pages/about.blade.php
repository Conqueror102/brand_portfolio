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

    @if (content_on('about.show_credentials') && items('credentials')->isNotEmpty())
        <section class="wrap section-tight">
            <header class="section-head">
                <div>
                    <p class="eyebrow">Education &amp; credentials</p>
                    <h2 class="display h-lg">{{ content_html('about.credentials_title') }}</h2>
                </div>
            </header>
            <div class="grid-4">
                @foreach (items('credentials') as $i => $credential)
                    <article class="card feature-card credential-card {{ ['card-white', 'card-cream', 'card-mist-soft', 'card-sand'][$i % 4] }}" data-reveal>
                        <span class="icon-chip"><x-line-icon :name="$credential->icon ?: 'book'" /></span>
                        <h3>{{ $credential->title }}</h3>
                        <p>{{ $credential->subtitle }}</p>
                    </article>
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

    @if (content_on('about.show_links'))
        <section class="wrap section-tight">
            <div class="grid-3">
                <a class="card card-white link-card" href="{{ route('speaking') }}" data-reveal>
                    <span class="icon-chip"><x-line-icon name="mic" /></span>
                    <h3 class="display h-sm">{{ content('navigation.speaking_label') }}</h3>
                    <p class="body-copy">Keynotes, panels, workshops and leadership retreats.</p>
                    <span class="link-card-arrow"><x-line-icon name="arrow-up-right" /></span>
                </a>
                <a class="card card-cream link-card" href="{{ route('mentorship') }}" data-reveal>
                    <span class="icon-chip"><x-line-icon name="steps" /></span>
                    <h3 class="display h-sm">Mentorship</h3>
                    <p class="body-copy">A {{ strtolower((string) cohort('duration')) }} programme from aspiration to results.</p>
                    <span class="link-card-arrow"><x-line-icon name="arrow-up-right" /></span>
                </a>
                @if (page_live('book'))
                    <a class="card card-mist link-card" href="{{ route('book') }}" data-reveal>
                        <span class="icon-chip"><x-line-icon name="book" /></span>
                        <h3 class="display h-sm">{{ content('navigation.book_label') }}</h3>
                        <p class="body-copy">{{ content('book.title') }}, {{ content('book.release') }}.</p>
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
