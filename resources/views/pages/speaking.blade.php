@php($engagements = items('engagements'))
@php($kit = items('resources')->where('category', 'speaker'))
<x-layouts.page :title="content('navigation.speaking_label')" :description="content('speaking.meta')">
    <section class="wrap page-hero">
        <div class="card card-navy card-glow page-hero-copy on-dark" data-reveal>
            <p class="eyebrow">{{ content('speaking.eyebrow') }}</p>
            <h1 class="display h-xl" style="color: #F4F1EC">{{ content_html('speaking.title') }}</h1>
            <p class="lede" style="color: #C9D0D7">{{ content('speaking.lede') }}</p>
            <div class="actions">
                <a class="btn btn-light" href="{{ route('contact', ['type' => 'speaking']) }}">{{ content('speaking.cta_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                <a class="link-arrow link-arrow-light" href="#topics">See the topics <x-line-icon name="arrow" /></a>
            </div>
        </div>
        <figure class="frame" data-reveal>
            <img src="{{ content_image('speaking.image') }}" alt="">
            @if ($first = items('speaking_formats')->first())<div class="frame-badge"><x-line-icon :name="$first->icon ?: 'mic'" /><div><strong>{{ $first->title }}</strong>Conferences and professional bodies</div></div>@endif
            @if ($last = items('speaking_formats')->last())<div class="frame-badge frame-badge-top"><x-line-icon :name="$last->icon ?: 'retreat'" /><div><strong>{{ \Illuminate\Support\Str::limit($last->title, 26) }}</strong>Partners and leadership teams</div></div>@endif
        </figure>
    </section>

    @if (content('speaking.profile_bio'))
        {{-- Speaker profile: the short bio organisers ask for, beside a studio portrait. --}}
        <section class="wrap section speaker-profile" id="profile" aria-labelledby="profile-title">
            <figure class="speaker-portrait" data-reveal>
                <img src="{{ content_image('speaking.profile_image') }}" alt="Portrait of {{ content('profile.given_name') }} {{ content('profile.surname') }}" loading="lazy" width="1100" height="1458">
            </figure>
            <div class="speaker-copy">
                <p class="eyebrow">{{ content('speaking.profile_eyebrow') }}</p>
                <h2 id="profile-title" class="display h-xl">{{ content_html('speaking.profile_title') }}</h2>
                @if (content('speaking.profile_role'))<p class="speaker-role">{{ content('speaking.profile_role') }}</p>@endif
                <div class="speaker-bio">
                    @foreach (preg_split('/\n\s*\n/', trim((string) content('speaking.profile_bio'))) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
                @php($facts = array_filter(array_map('trim', explode("\n", (string) content('speaking.profile_facts')))))
                @if ($facts)
                    <dl class="speaker-facts">
                        @foreach ($facts as $fact)
                            @php([$role, $org] = array_pad(array_map('trim', explode('|', $fact, 2)), 2, ''))
                            <div><dt>{{ $role }}</dt>@if ($org)<dd>{{ $org }}</dd>@endif</div>
                        @endforeach
                    </dl>
                @endif
                <div class="actions">
                    <a class="btn" href="{{ route('contact', ['type' => 'speaking']) }}">{{ content('speaking.cta_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                    @if (content('speaking.profile_link'))<a class="link-arrow" href="{{ content_url('speaking.profile_link') }}" target="_blank" rel="noopener">{{ content('speaking.profile_link_label') }} <x-line-icon name="download" /></a>@endif
                </div>
            </div>
        </section>
    @endif

    <section class="wrap section" id="topics">
        <header class="section-head">
            <div>
                <p class="eyebrow">Signature topics</p>
                <h2 class="display h-lg">{{ content_html('speaking.topics_title') }}</h2>
            </div>
            <p class="lede" style="max-width: 26em">{{ content('speaking.topics_lede') }}</p>
        </header>
        <div class="grid-3">
            @foreach (items('speaking_topics') as $i => $topic)
                <article class="card feature-card {{ ['card-mist-soft', 'card-cream', 'card-white', 'card-sand', 'card-mist', 'card-navy card-glow'][$i % 6] }}" data-reveal>
                    <div class="feature-card-top">
                        <span class="icon-chip"><x-line-icon :name="$topic->icon ?: 'spark'" /></span>
                        <span class="idea-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h3>{{ $topic->title }}</h3>
                    <p>{{ $topic->body }}</p>
                    @if ($topic->subtitle)<p class="takeaway"><x-line-icon name="check" /> {{ $topic->subtitle }}</p>@endif
                </article>
            @endforeach
        </div>
    </section>

    <section class="wrap section-tight">
        <div class="formats-band card card-sand" data-reveal>
            <div>
                <p class="eyebrow">Formats</p>
                <h2 class="display h-md" style="margin-top: 16px">{{ content_html('speaking.formats_title') }}</h2>
            </div>
            <ul class="format-list">
                @foreach (items('speaking_formats') as $format)
                    <li><span class="icon-chip"><x-line-icon :name="$format->icon ?: 'mic'" /></span>{{ $format->title }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    @if (items('speaking_audiences')->isNotEmpty())
        <section class="wrap section-tight">
            <div class="split">
                <div class="sticky-col" data-reveal>
                    <p class="eyebrow">Who it is for</p>
                    <h2 class="display h-lg" style="margin-top: 18px">{{ content_html('speaking.audiences_title') }}</h2>
                    <p class="lede" style="margin-top: 18px">Every invitation is reviewed personally before a date is confirmed.</p>
                </div>
                <ol class="list-lines" data-reveal>
                    @foreach (items('speaking_audiences') as $i => $audience)
                        <li><span class="num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span><p>{{ $audience->title }}</p></li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    @if ($engagements->isNotEmpty())
        <section class="wrap section-tight">
            <header class="section-head">
                <div>
                    <p class="eyebrow">Engagements</p>
                    <h2 class="display h-lg">{{ content_html('speaking.engagements_title') }}</h2>
                </div>
            </header>
            <div class="engagement-list">
                @foreach ($engagements as $engagement)
                    <article class="engagement" data-reveal>
                        @if ($engagement->imageUrl())<img src="{{ $engagement->imageUrl() }}" alt="{{ $engagement->imageAlt() }}" loading="lazy">@endif
                        <time>{{ $engagement->date?->format('M Y') }}</time>
                        <div>
                            <h3>{{ $engagement->title }}</h3>
                            @if ($engagement->subtitle)<p class="engagement-sub">{{ $engagement->subtitle }}</p>@endif
                            @if ($engagement->body)<p>{{ $engagement->body }}</p>@endif
                        </div>
                        @if ($engagement->url)<a class="insight-arrow" href="{{ $engagement->url }}" target="_blank" rel="noopener noreferrer" aria-label="More about {{ $engagement->title }}"><x-line-icon name="arrow-up-right" /></a>@endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if (content_on('speaking.show_testimonials') && $testimonials->isNotEmpty())
        <section class="wrap section-tight">
            <div class="grid-2">
                @foreach ($testimonials as $i => $testimonial)
                    @include('partials.quote', ['testimonial' => $testimonial, 'class' => $i % 2 ? 'card-navy card-glow' : 'card-white'])
                @endforeach
            </div>
        </section>
    @endif

    @if (content_on('speaking.show_process') && items('speaking_steps')->isNotEmpty())
        <section class="wrap section-tight">
            <div class="process card card-white" data-reveal>
                <p class="eyebrow">How invitations work</p>
                <ol class="process-steps">
                    @foreach (items('speaking_steps') as $step)
                        <li><span class="icon-chip"><x-line-icon :name="$step->icon ?: 'check'" /></span><strong>{{ $step->title }}</strong><p>{{ $step->body }}</p></li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    @if ($kit->isNotEmpty())
        <section class="wrap section-tight">
            @include('partials.downloads', ['title' => 'Speaker kit', 'resources' => $kit])
        </section>
    @endif

    <x-site.cta :title="content('speaking.cta_title')" type="speaking" />
</x-layouts.page>
