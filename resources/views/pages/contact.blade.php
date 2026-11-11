@php
    $email = \App\Models\Setting::get('contact_email');
    $eventTypes = 'speaking,panel,workshop,retreat';
@endphp
<x-layouts.page :title="content('navigation.contact_label')" :description="content('contact.meta')">
    <section class="wrap page-hero-simple">
        <p class="eyebrow">{{ content('contact.eyebrow') }}</p>
        <h1 class="display h-xl">{{ content_html('contact.title') }}</h1>
        <p class="lede">{{ content('contact.lede') }}</p>
    </section>

    <section class="wrap section-tight">
        <div class="contact-shell">
            <div class="card card-white contact-form-card">
                @if (session('enquiry_saved'))
                    <div class="success-state" role="status">
                        <span class="success-icon"><x-line-icon name="check" /></span>
                        <h2 class="display h-md">Thank you. Your request has been received.</h2>
                        <p class="body-copy">{{ content('contact.success') }}</p>
                        <a class="link-arrow" href="{{ route('home') }}">Back to the homepage <x-line-icon name="arrow" /></a>
                    </div>
                @else
                    @if ($errors->any())
                        <div class="alert alert-error" role="alert"><x-line-icon name="close" /> Please check the highlighted fields and try again.</div>
                    @endif
                    <form class="form" method="POST" action="{{ route('enquiries.store') }}" data-once>
                        @csrf
                        <div class="hp" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
                        @php
                            $cards = ['speaking' => 'mic', 'panel' => 'panel', 'workshop' => 'workshop', 'retreat' => 'retreat'];
                            $chosen = old('type', $selectedType);
                            $isOther = $chosen && ! array_key_exists($chosen, $cards);
                            $others = \Illuminate\Support\Arr::except(config('site.enquiry_types'), array_keys($cards));
                            $option = fn ($key) => array_pad(array_map('trim', explode('|', (string) content('contact.type_'.$key), 2)), 2, '');
                        @endphp
                        <fieldset class="field engage-types">
                            <legend>{{ content('contact.type_question') }}</legend>
                            <div class="engage-grid">
                                @foreach ($cards as $value => $icon)
                                    @php([$title, $line] = $option($value))
                                    <label class="engage-card">
                                        <input type="radio" name="type" value="{{ $value }}" required @checked($chosen === $value)>
                                        <span class="engage-icon"><x-line-icon :name="$icon" /></span>
                                        <strong>{{ $title }}</strong>
                                        @if ($line)<small>{{ $line }}</small>@endif
                                        <i class="engage-tick" aria-hidden="true"><x-line-icon name="check" /></i>
                                    </label>
                                @endforeach
                                @php([$title, $line] = $option('other'))
                                <label class="engage-card engage-card-other">
                                    <input type="radio" name="type" value="other" @checked($isOther)>
                                    <span class="engage-icon"><x-line-icon name="spark" /></span>
                                    <strong>{{ $title }}</strong>
                                    @if ($line)<small>{{ $line }}</small>@endif
                                    <i class="engage-tick" aria-hidden="true"><x-line-icon name="check" /></i>
                                </label>
                            </div>
                            <label class="field engage-other">
                                <span>Please choose</span>
                                <select name="type_other">
                                    @foreach ($others as $value => $label)
                                        <option value="{{ $value }}" @selected($isOther && $chosen === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </label>
                            @error('type')<span class="field-error">{{ $message }}</span>@enderror
                        </fieldset>
                        <div class="form-row">
                            <x-field name="name" label="Your name" autocomplete="name" required maxlength="150" />
                            <x-field name="email" label="Email address" type="email" autocomplete="email" required maxlength="254" />
                        </div>
                        <div class="form-row">
                            <x-field name="organisation" label="Organisation" optional autocomplete="organization" />
                            <x-field name="phone" label="Phone" optional autocomplete="tel" />
                        </div>
                        <div class="conditional form-sub" data-show-when="type" data-show-values="{{ $eventTypes }}">
                            <p class="form-sub-title"><x-line-icon name="calendar" /> Event details</p>
                            <div class="form-row">
                                <x-field name="proposed_date" label="Proposed date" optional placeholder="e.g. 14 March 2027" />
                                <x-field name="location" label="Location or format" optional placeholder="City, venue or virtual" />
                            </div>
                            <div class="form-row">
                                <x-field name="audience" label="Audience" optional placeholder="Who will be in the room?" />
                                <x-field name="participants" label="Number of participants" type="number" min="1" optional />
                            </div>
                        </div>
                        <x-field name="message" label="Topic, objectives and anything else we should know" type="textarea" required minlength="10" maxlength="5000" />
                        <button class="btn" type="submit">Send request <span class="btn-icon"><x-line-icon name="arrow" /></span></button>
                    </form>
                @endif
            </div>

            <aside class="contact-aside">
                <div class="card card-navy card-glow" data-reveal>
                    <p class="eyebrow">What happens next</p>
                    <ol class="apply-steps">
                        @foreach (array_values(array_filter(array_map('trim', explode("\n", (string) content('contact.steps'))))) as $i => $step)
                            <li><span>{{ $i + 1 }}</span>{{ $step }}</li>
                        @endforeach
                    </ol>
                </div>
                <div class="card card-cream contact-direct" data-reveal>
                    <span class="icon-chip"><x-line-icon name="mail" /></span>
                    <div>
                        <p class="stat-label">Prefer email?</p>
                        @if ($email)
                            <a class="contact-email" href="mailto:{{ $email }}">{{ $email }}</a>
                        @else
                            <p class="body-copy">Use the form and your message reaches the team directly.</p>
                        @endif
                    </div>
                </div>
                <a class="card card-mist-soft contact-direct link-card" href="{{ route('mentorship') }}" data-reveal>
                    <span class="icon-chip"><x-line-icon name="steps" /></span>
                    <div>
                        <p class="stat-label">Looking for mentorship?</p>
                        <p class="body-copy">The programme has its own application.</p>
                    </div>
                    <span class="link-card-arrow"><x-line-icon name="arrow-up-right" /></span>
                </a>
            </aside>
        </div>
    </section>
</x-layouts.page>
