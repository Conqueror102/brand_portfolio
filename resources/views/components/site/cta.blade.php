@props(['title' => null, 'type' => 'speaking', 'eyebrow' => 'Start a conversation'])
<section class="wrap section-tight">
    <div class="cta-band" data-reveal>
        <div>
            <p class="eyebrow eyebrow-light">{{ $eyebrow }}</p>
            <h2 class="display h-lg cta-title">{{ $title ?: strip_tags(content_html('home.cta_title')) }}</h2>
            <p class="cta-copy">{{ content('home.cta_text') }}</p>
        </div>
        <div class="cta-actions">
            <a class="btn btn-light" href="{{ route('contact', ['type' => $type]) }}">Start your request <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            <a class="btn btn-apricot btn-ghost-dark" href="{{ route('mentorship') }}">Mentorship programme <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
        </div>
    </div>
</section>
