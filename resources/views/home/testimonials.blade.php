@if ($testimonials->isNotEmpty())
<section class="home-testimonials wrap section" aria-labelledby="testimonials-title">
    <header class="section-head">
        <div>
            <p class="eyebrow">{{ content('home.testimonials_eyebrow') }}</p>
            <h2 id="testimonials-title" class="display h-lg">{{ content_html('home.testimonials_title') }}</h2>
        </div>
    </header>
    <div class="grid-3">
        @foreach ($testimonials as $i => $testimonial)
            @include('partials.quote', ['testimonial' => $testimonial, 'class' => ['card-white', 'card-navy card-glow', 'card-sand'][$i % 3]])
        @endforeach
    </div>
</section>
@endif
