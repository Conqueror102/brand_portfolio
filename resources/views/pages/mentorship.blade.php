@php
    $statusLabel = mentorship_status_label($status);
    $journey = items('journey');
@endphp
<x-layouts.page title="The Mentorship Programme" :description="content('mentorship.meta')">
    <section class="wrap page-hero">
        <div class="card card-cream page-hero-copy" data-reveal>
            <div class="home-mentorship-top">
                <p class="eyebrow">The Mentorship Programme · {{ $cohort }}</p>
                <span class="status-pill status-{{ $status }}">{{ $statusLabel }}</span>
            </div>
            <h1 class="display h-xl">{{ content_html('mentorship.title') }}</h1>
            <p class="lede">{{ content('mentorship.lede') }}</p>
            <div class="actions">
                @if ($status === 'open')
                    <a class="btn" href="#apply">Apply for the programme <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                @else
                    <a class="btn" href="{{ route('contact', ['type' => 'mentorship']) }}">Register your interest <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                @endif
                <a class="link-arrow" href="#who">Who it is for <x-line-icon name="arrow" /></a>
            </div>
        </div>
        <figure class="frame" data-reveal>
            <img src="{{ content_image('mentorship.image') }}" alt="">
            <div class="frame-badge frame-badge-top"><x-line-icon name="people" /><div><strong>{{ cohort('capacity') ?: 'Limited cohort' }}</strong>Application based</div></div>
            <div class="frame-badge"><x-line-icon name="calendar" /><div><strong>{{ cohort('period') }}{{ cohort('year') ? ' '.cohort('year') : '' }}</strong>{{ cohort('sessions') }}</div></div>
        </figure>
    </section>

    {{-- Who it is for: first thing after the opening, so visitors can tell straight away whether it is meant for them. --}}
    <section class="wrap section mentor-who" id="who" aria-labelledby="who-title">
        <div class="split">
            <div class="sticky-col" data-reveal>
                <p class="eyebrow">Is this for you?</p>
                <h2 id="who-title" class="display h-lg" style="margin-top: 18px">{{ content_html('mentorship.audience_title') }}</h2>
                <p class="lede" style="margin-top: 18px">{{ content('mentorship.audience_text') }}</p>
            </div>
            <div>
                @php($profiles = array_filter(array_map('trim', explode("\n", (string) content('mentorship.audience_profiles')))))
                @if ($profiles)
                    <ol class="mentor-profiles" data-reveal>
                        @foreach ($profiles as $i => $row)
                            @php([$person, $why] = array_pad(array_map('trim', explode('|', $row, 2)), 2, ''))
                            <li><span class="num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span><div><h3>{{ $person }}</h3>@if ($why)<p>{{ $why }}</p>@endif</div></li>
                        @endforeach
                    </ol>
                @endif
                @if (items('mentorship_audience')->isNotEmpty())
                    <p class="mentor-fit-title">{{ content('mentorship.audience_fit_title') }}</p>
                    <ul class="check-list" data-reveal>
                        @foreach (items('mentorship_audience') as $line)
                            <li><span class="check-dot"><x-line-icon name="check" /></span>{{ $line->title }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>

    <section class="wrap section" id="how">
        <header class="section-head">
            <div>
                <p class="eyebrow">The journey</p>
                <h2 class="display h-lg">{{ content_html('mentorship.journey_title') }}</h2>
            </div>
        </header>
        <ol class="journey-cards" style="--steps: {{ max(1, min(5, $journey->count())) }}">
            @foreach ($journey as $i => $stage)
                <li class="card {{ $loop->last ? 'card-navy card-glow' : ['card-mist-soft', 'card-cream', 'card-sand', 'card-mist'][$i % 4] }}" data-reveal>
                    <span class="journey-card-top"><span class="icon-chip"><x-line-icon :name="$stage->icon ?: (['star', 'eye', 'steps', 'calendar', 'check'][$i] ?? 'check')" /></span><span class="idea-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span></span>
                    <h3 class="display h-sm">{{ $stage->title }}</h3>
                    <p>{{ $stage->body }}</p>
                </li>
            @endforeach
        </ol>
    </section>


    <section class="wrap section-tight">
        <div class="grid-4">
            @foreach (array_filter([['calendar', 'Opening session', cohort('opening')], ['clock', 'Weekly sessions', trim(cohort('sessions').' '.(cohort('timezone') ?? ''))], ['heart', 'Closing session', cohort('closing')], ['star', 'Investment', cohort('fee') ? cohort('fee').', after acceptance' : null], ['globe', 'Delivery', cohort('delivery')], ['people', 'Cohort size', cohort('capacity')]], fn ($row) => filled($row[2])) as $i => [$icon, $title, $text])
                <article class="card stat-card {{ ['card-white', 'card-mist-soft', 'card-white', 'card-sand'][$loop->index % 4] }}" data-reveal>
                    <span class="icon-chip"><x-line-icon :name="$icon" /></span>
                    <p class="stat-label">{{ $title }}</p>
                    <p class="stat-value">{{ $text }}</p>
                </article>
            @endforeach
        </div>
        @if (content('mentorship.schedule_note'))<p class="fine-print">{{ content('mentorship.schedule_note') }}</p>@endif
    </section>

    @if (items('mentorship_includes')->isNotEmpty())
        <section class="wrap section-tight">
            <header class="section-head"><div><p class="eyebrow">What is included</p></div></header>
            <div class="grid-3">
                @foreach (items('mentorship_includes') as $include)
                    <article class="card feature-card card-white" data-reveal>
                        <span class="icon-chip"><x-line-icon :name="$include->icon ?: 'check'" /></span>
                        <h3>{{ $include->title }}</h3>
                        <p>{{ $include->body }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if (content_on('mentorship.show_testimonials') && $testimonials->isNotEmpty())
        <section class="wrap section-tight">
            <div class="grid-{{ min(3, $testimonials->count()) }}">
                @foreach ($testimonials as $i => $testimonial)
                    @include('partials.quote', ['testimonial' => $testimonial, 'class' => ['card-white', 'card-navy card-glow', 'card-sand'][$i % 3]])
                @endforeach
            </div>
        </section>
    @endif

    <section class="wrap section-tight" id="apply">
        <div class="apply-shell">
            <aside class="card card-navy card-glow apply-aside" data-reveal>
                <p class="eyebrow">Application</p>
                <h2 class="display h-lg" style="margin-top: 18px; color: #F4F1EC">Apply for the <em class="em-light">{{ \Illuminate\Support\Str::lower($cohort) }}.</em></h2>
                <ol class="apply-steps">
                    <li><span>1</span>Submit your application</li>
                    <li><span>2</span>It is reviewed personally</li>
                    <li><span>3</span>If accepted, you receive payment and onboarding details</li>
                </ol>
                @if ($deadline)
                    <p class="apply-deadline"><x-line-icon name="clock" /> Applications close {{ nice_date($deadline) }}</p>
                @endif
                <p class="apply-note"><x-line-icon name="lock" /> You do not pay anything to apply.</p>
            </aside>

            <div class="card card-white apply-form-card">
                @if (session('application_saved'))
                    <div class="success-state" role="status">
                        <span class="success-icon"><x-line-icon name="check" /></span>
                        <h3 class="display h-md">Thank you. Your application has been received.</h3>
                        <p class="body-copy">{{ content('mentorship.apply_success') }}</p>
                        <a class="link-arrow" href="{{ route('insights.index') }}">Read the insights while you wait <x-line-icon name="arrow" /></a>
                    </div>
                @elseif ($status !== 'open')
                    <div class="success-state">
                        <span class="success-icon success-icon-muted"><x-line-icon name="calendar" /></span>
                        <h3 class="display h-md">{{ $statusLabel }}.</h3>
                        <p class="body-copy">{{ $status === 'forthcoming' ? 'Applications for the next cohort will open soon.' : 'Applications for this cohort are not being accepted right now.' }} Register your interest and we will let you know when the next window opens.</p>
                        <a class="btn" href="{{ route('contact', ['type' => 'mentorship']) }}">Register your interest <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                    </div>
                @else
                    @if ($errors->any())
                        <div class="alert alert-error" role="alert"><x-line-icon name="close" /> Please check the highlighted fields and try again.</div>
                    @endif
                    <form class="form" method="POST" action="{{ route('mentorship.apply') }}" data-once>
                        @csrf
                        <div class="hp" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>

                        <fieldset class="form-group">
                            <legend><span>01</span> About you</legend>
                            <div class="form-row">
                                <x-field name="name" label="Full name" autocomplete="name" required />
                                <x-field name="email" label="Email address" type="email" autocomplete="email" required />
                            </div>
                            <div class="form-row">
                                <x-field name="phone" label="Phone" optional autocomplete="tel" />
                                <x-field name="location" label="Location and time zone" required placeholder="e.g. Lagos, WAT" />
                            </div>
                            <x-field name="role" label="Current role or profession" required />
                        </fieldset>

                        <fieldset class="form-group">
                            <legend><span>02</span> Your goals</legend>
                            <x-field name="goals" label="What goals are you working towards?" type="textarea" required />
                            <x-field name="outcomes" label="What would success look like in six months?" type="textarea" required />
                            <x-field name="motivation" label="Why is now the right time?" type="textarea" required />
                            <x-field name="support" label="What support would help you most?" type="textarea" optional />
                        </fieldset>

                        <fieldset class="form-group">
                            <legend><span>03</span> Commitment</legend>
                            <div class="field">
                                <span>Can you attend the weekly sessions ({{ cohort('sessions') }})?</span>
                                <div class="choice-group choice-row">
                                    @foreach (['consistently' => 'Yes, consistently', 'mostly' => 'Most weeks', 'unsure' => 'Not sure yet'] as $value => $label)
                                        <label class="choice"><input type="radio" name="availability" value="{{ $value }}" @checked(old('availability') === $value) required> {{ $label }}</label>
                                    @endforeach
                                </div>
                                @error('availability')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <span>Can you attend the in-person opening and closing sessions?</span>
                                <div class="choice-group choice-row">
                                    @foreach (['yes' => 'Yes', 'unsure' => 'Not sure yet', 'no' => 'No'] as $value => $label)
                                        <label class="choice"><input type="radio" name="in_person" value="{{ $value }}" @checked(old('in_person') === $value) required> {{ $label }}</label>
                                    @endforeach
                                </div>
                                @error('in_person')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <x-field name="commitment" label="How will you make time for the work between sessions?" type="textarea" required />
                        </fieldset>

                        <div class="consents">
                            <label class="check"><input type="checkbox" name="privacy" value="1" @checked(old('privacy')) required> <span>{{ content('mentorship.privacy_text') }} <a href="{{ route('privacy') }}">Read the privacy notice</a>.</span></label>
                            @error('privacy')<span class="field-error">{{ $message }}</span>@enderror
                            <label class="check"><input type="checkbox" name="marketing_consent" value="1" @checked(old('marketing_consent'))> <span>Optional: send me occasional updates about future programmes and insights.</span></label>
                        </div>
                        <button class="btn" type="submit">Submit application <span class="btn-icon"><x-line-icon name="arrow" /></span></button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    @if (items('faqs')->isNotEmpty())
    <section class="wrap section-tight">
        <header class="section-head">
            <div>
                <p class="eyebrow">Questions</p>
                <h2 class="display h-lg">Good to <em>know.</em></h2>
            </div>
        </header>
        <div class="faq">
            @foreach (items('faqs') as $faq)
                <details class="faq-item" data-reveal>
                    <summary>{{ $faq->title }}<span class="faq-toggle"><x-line-icon name="plus" /></span></summary>
                    <p>{{ $faq->body }}</p>
                </details>
            @endforeach
        </div>
    </section>
    @endif
</x-layouts.page>
