@php
    $email = \App\Models\Setting::get('contact_email');
    $linkedin = \App\Models\Setting::get('linkedin_url');
    $instagram = \App\Models\Setting::get('instagram_url');
    $pages = site_pages();
@endphp
<footer class="site-footer">
    <div class="site-footer-top">
        <div class="site-footer-brand">
            <a class="site-footer-mark" href="{{ route('home') }}" aria-label="{{ content('seo.site_name') }} home"><x-brand-mark variant="plain" /></a>
            <p class="site-footer-name">{{ content('profile.given_name') }} <em>{{ content('profile.surname') }}</em><span class="name-dot">.</span></p>
            <p class="site-footer-line">{{ content('profile.tagline') }}</p>
            @if ($linkedin || $instagram)
                <div class="site-footer-social">
                    @if ($linkedin)<a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><x-line-icon name="linkedin" /></a>@endif
                    @if ($instagram)<a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><x-line-icon name="instagram" /></a>@endif
                </div>
            @endif
        </div>
        <nav aria-label="Explore">
            <p>Explore</p>
            @foreach ($pages as $key => $page)
                @unless ($key === 'contact')<a href="{{ $page['url'] }}">{{ $page['label'] }}</a>@endunless
            @endforeach
        </nav>
        <nav aria-label="Engage">
            <p>Engage</p>
            <a href="{{ route('contact', ['type' => 'speaking']) }}">Invite me to speak</a>
            <a href="{{ route('contact', ['type' => 'session']) }}">Book a session</a>
            <a href="{{ route('mentorship') }}#apply">Apply for mentorship</a>
            @isset($pages['book'])<a href="{{ $pages['book']['url'] }}">{{ $pages['book']['label'] }}</a>@endisset
            <a href="{{ route('contact') }}">{{ content('navigation.contact_label') }}</a>
        </nav>
        <div class="site-footer-cta">
            <p>{{ content('footer.cta_title') }}</p>
            <a class="btn btn-light" href="{{ content_url('footer.cta_link') }}">{{ content('footer.cta_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            @if ($email)<a class="site-footer-mail" href="mailto:{{ $email }}"><x-line-icon name="mail" /> {{ $email }}</a>@endif
        </div>
    </div>
    @if (content_on('footer.newsletter_on'))
        <div class="site-footer-news" id="newsletter">
            <div>
                <p class="site-footer-news-title">{{ content('footer.newsletter_title') }}</p>
                <p class="site-footer-news-text">{{ content('footer.newsletter_text') }}</p>
            </div>
            @if (session('subscribed'))
                <p class="site-footer-news-done" role="status"><x-line-icon name="check" /> Thank you. You are subscribed.</p>
            @else
                <form class="site-footer-news-form" method="POST" action="{{ route('subscribe') }}" data-once>
                    @csrf
                    <div class="hp" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
                    <div class="site-footer-news-row">
                        <label class="sr-only" for="news-email">Email address</label>
                        <input id="news-email" type="email" name="email" placeholder="Your email address" required autocomplete="email" value="{{ old('email') }}">
                        <button class="btn btn-light btn-plain" type="submit">Subscribe</button>
                    </div>
                    <fieldset class="site-footer-news-interests">
                        <legend class="sr-only">Interested in</legend>
                        @foreach (config('site.interests') as $value => $label)
                            <label><input type="checkbox" name="interests[]" value="{{ $value }}" @checked(in_array($value, old('interests', ['insights'])))> {{ $label }}</label>
                        @endforeach
                    </fieldset>
                    @error('email', 'newsletter')<span class="field-error">{{ $message }}</span>@enderror
                </form>
            @endif
        </div>
    @endif
    <div class="site-footer-base">
        <p>© {{ date('Y') }} {{ content('footer.copyright') }}. All rights reserved.</p>
        <div><a href="{{ route('privacy') }}">Privacy</a><a href="https://icons8.com" target="_blank" rel="noopener noreferrer">Some icons by Icons8</a></div>
    </div>
</footer>
