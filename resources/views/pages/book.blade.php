@php($open = \App\Models\Setting::flag('book_waitlist_open'))
<x-layouts.page :title="content('navigation.book_label')" :description="content('book.meta')">
    <section class="wrap section-tight">
        <div class="book-hero card card-sand" data-reveal>
            <div class="book-hero-art">@include('partials.book-cover', ['large' => true])</div>
            <div class="book-hero-copy">
                <p class="eyebrow">{{ content('navigation.book_label') }} · {{ content('book.release') }}</p>
                <h1 class="display h-xl">{{ content('book.title') }}</h1>
                <p class="lede">{{ content('book.synopsis') }}</p>
                <dl class="facts">
                    <div><dt>Release</dt><dd>{{ content('book.release') }}</dd></div>
                    <div><dt>Formats</dt><dd>{{ content('book.formats') }}</dd></div>
                    <div><dt>Price</dt><dd>{{ content('book.price') }}</dd></div>
                </dl>
                <div class="actions">
                    @if (content('book.order_link'))
                        <a class="btn" href="{{ content_url('book.order_link') }}">{{ content('book.order_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                    @endif
                    @if ($open)<a class="{{ content('book.order_link') ? 'link-arrow' : 'btn' }}" href="#waitlist">Join the waiting list @if (content('book.order_link'))<x-line-icon name="arrow" />@else<span class="btn-icon"><x-line-icon name="arrow" /></span>@endif</a>@endif
                    <a class="link-arrow" href="{{ route('contact', ['type' => 'book']) }}">Book-related engagements <x-line-icon name="arrow" /></a>
                </div>
            </div>
        </div>
    </section>

    @if (items('book_themes')->isNotEmpty())
        <section class="wrap section-tight">
            <div class="split">
                <div class="sticky-col" data-reveal>
                    <p class="eyebrow">Inside the book</p>
                    <h2 class="display h-lg" style="margin-top: 18px">The themes it <em>explores.</em></h2>
                    <p class="lede" style="margin-top: 18px">{{ content('book.audience') }}</p>
                </div>
                <ol class="theme-grid" data-reveal>
                    @foreach (items('book_themes') as $i => $theme)
                        <li><span>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>{{ $theme->title }}</li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    @if (items('book_endorsements')->isNotEmpty())
        <section class="wrap section-tight">
            <div class="grid-{{ min(3, items('book_endorsements')->count()) }}">
                @foreach (items('book_endorsements') as $i => $endorsement)
                    <figure class="card quote-card {{ ['card-white', 'card-navy card-glow', 'card-sand'][$i % 3] }}" data-reveal>
                        <span class="quote-mark" aria-hidden="true">“</span>
                        <blockquote><p>{{ $endorsement->body }}</p></blockquote>
                        <footer><span class="avatar">{{ mb_substr($endorsement->title, 0, 1) }}</span><div><strong>{{ $endorsement->title }}</strong><span>{{ $endorsement->subtitle }}</span></div></footer>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

    @if ($testimonials->isNotEmpty())
        <section class="wrap section-tight">
            <div class="grid-{{ min(3, $testimonials->count()) }}">
                @foreach ($testimonials as $i => $testimonial)
                    @include('partials.quote', ['testimonial' => $testimonial, 'class' => ['card-white', 'card-sand', 'card-mist-soft'][$i % 3]])
                @endforeach
            </div>
        </section>
    @endif

    <section class="wrap section-tight" id="waitlist">
        <div class="waitlist card card-navy card-glow">
            <div>
                <p class="eyebrow">Waiting list</p>
                <h2 class="display h-lg" style="margin-top: 18px; color: #F4F1EC">{{ content_html('book.waitlist_title') }}</h2>
                <p style="margin-top: 16px">{{ content('book.waitlist_text') }}</p>
            </div>
            <div class="waitlist-form">
                @if (session('waitlist_saved'))
                    <div class="alert alert-success" role="status"><x-line-icon name="check" /> You are on the list. We will be in touch as the launch approaches.</div>
                @elseif (! $open)
                    <div class="alert alert-info">The waiting list is closed for now. Please check back soon.</div>
                @else
                    <form class="form" method="POST" action="{{ route('waitlist.store') }}" data-once>
                        @csrf
                        <div class="hp" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
                        <div class="form-row">
                            <x-field name="name" label="Name" autocomplete="name" required />
                            <x-field name="email" label="Email" type="email" autocomplete="email" required />
                        </div>
                        <div class="field">
                            <span>Preferred format</span>
                            <div class="choice-group choice-row">
                                @foreach (['print' => 'Print', 'digital' => 'Digital', 'either' => 'Either'] as $value => $label)
                                    <label class="choice"><input type="radio" name="format" value="{{ $value }}" @checked(old('format', 'either') === $value)> {{ $label }}</label>
                                @endforeach
                            </div>
                        </div>
                        <label class="check"><input type="checkbox" name="marketing_consent" value="1"> <span>Optional: also send me occasional insights.</span></label>
                        <button class="btn btn-light" type="submit">Join the waiting list <span class="btn-icon"><x-line-icon name="arrow" /></span></button>
                    </form>
                @endif
            </div>
        </div>
    </section>
</x-layouts.page>
