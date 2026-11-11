<section class="home-speaking wrap" id="speaking" aria-labelledby="speaking-title">
    <div class="card card-navy card-glow home-speaking-intro" data-reveal>
        <p class="eyebrow">{{ content('home.speaking_eyebrow') }}</p>
        <h2 id="speaking-title" class="display h-lg">{{ content_html('home.speaking_title') }}</h2>
        <p class="body-copy">{{ content('home.speaking_text') }}</p>
        <ul class="home-formats">
            @foreach (items('speaking_formats') as $format)
                <li><x-line-icon :name="$format->icon ?: 'mic'" /> {{ $format->title }}</li>
            @endforeach
        </ul>
        <div class="actions">
            <a class="btn btn-light" href="{{ route('contact', ['type' => 'speaking']) }}">{{ content('speaking.cta_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            <a class="link-arrow" href="{{ route('speaking') }}#profile">Speaker profile <x-line-icon name="arrow" /></a>
        </div>
    </div>
    <div class="home-topics">
        @foreach (items('speaking_topics')->take(4) as $i => $topic)
            <article class="card feature-card {{ ['card-mist-soft', 'card-cream', 'card-sand', 'card-mist'][$i % 4] }}" data-reveal>
                <span class="icon-chip"><x-line-icon :name="$topic->icon ?: 'spark'" /></span>
                <h3>{{ $topic->title }}</h3>
                <p>{{ $topic->body }}</p>
            </article>
        @endforeach
    </div>
</section>
