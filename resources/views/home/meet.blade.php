<section class="meet" id="meet" aria-labelledby="meet-title">
    <div class="meet-intro">
        <p class="meet-eyebrow">{{ content('home.meet_eyebrow') }}</p>
        <h2 id="meet-title">{{ content('home.meet_title') }}</h2>
        <p>{{ content('home.meet_text') }}</p>
        <a class="meet-pill" href="{{ content_url('home.meet_button_link') }}">{{ content('home.meet_button_label') }} <x-icon name="arrow-right-white" /></a>
    </div>
    <figure class="meet-portrait">
        <img src="{{ content_image('profile.portrait') }}" alt="{{ content('profile.portrait_alt') }}" loading="lazy" width="1100" height="1429">
        @if (content('profile.portrait_note'))<figcaption>{{ content('profile.portrait_note') }}</figcaption>@endif
    </figure>
    <div class="meet-photo">
        <img src="{{ content_image('home.meet_photo') }}" alt="" loading="lazy" width="700" height="410">
        @if (content('home.meet_badge_value'))<p class="meet-badge"><strong>{{ content('home.meet_badge_value') }}</strong><span>{{ content('home.meet_badge_label') }}</span></p>@endif
    </div>
    <article class="meet-perspective">
        <div class="meet-perspective-head">
            <h3>Perspective</h3>
            <a class="meet-arrow" href="{{ content_url('home.meet_button_link') }}" aria-label="Read more"><x-icon name="arrow-right" /></a>
        </div>
        <p class="meet-perspective-title">{{ content('home.meet_perspective_title') }}</p>
        <p>{{ content('home.meet_perspective_text') }}</p>
        <ul>
            @foreach (array_filter(array_map('trim', explode("\n", (string) content('home.meet_roles')))) as $role)
                <li>{{ $role }}</li>
            @endforeach
        </ul>
    </article>
    <aside class="meet-connect">
        <h3>{{ content('home.meet_connect_title') }}</h3>
        <p>{{ content('home.meet_connect_text') }}</p>
        <a class="meet-pill meet-pill-light" href="{{ content_url('home.meet_connect_link') }}">{{ content('home.meet_connect_label') }} <x-icon name="arrow-right" /></a>
    </aside>
</section>
