<figure class="card quote-card {{ $class }}" data-reveal>
    <span class="quote-mark" aria-hidden="true">“</span>
    <blockquote><p>{{ $testimonial->quote }}</p></blockquote>
    <footer>
        <span class="avatar">@if ($testimonial->portraitUrl())<img src="{{ $testimonial->portraitUrl() }}" alt="">@else{{ mb_substr($testimonial->name, 0, 1) }}@endif</span>
        <div><strong>{{ $testimonial->name }} @if ($testimonial->is_sample)<span class="sample-badge">Sample</span>@endif</strong><span>{{ $testimonial->attribution() }}</span></div>
    </footer>
</figure>
