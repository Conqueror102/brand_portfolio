<section class="wrap section-tight" aria-labelledby="final-title">
    <div class="cta-band" data-reveal>
        <div>
            <p class="eyebrow eyebrow-light">{{ content('home.cta_eyebrow') }}</p>
            <h2 id="final-title" class="display h-lg cta-title">{{ content_html('home.cta_title') }}</h2>
            <p class="cta-copy">{{ content('home.cta_text') }}</p>
        </div>
        <div class="cta-actions">
            <a class="btn btn-light" href="{{ content_url('home.cta_primary_link') }}">{{ content('home.cta_primary_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            @if (content('home.cta_secondary_label'))<a class="btn btn-apricot btn-ghost-dark" href="{{ content_url('home.cta_secondary_link') }}">{{ content('home.cta_secondary_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>@endif
        </div>
    </div>
</section>
