<x-admin-layout title="Testimonials">
    <x-slot:actions><a class="btn" href="{{ route('admin.testimonials.create') }}">Add testimonial <span class="btn-icon"><x-line-icon name="plus" /></span></a></x-slot:actions>
    @if ($testimonials->isEmpty())
        <section class="admin-panel"><p class="admin-empty">No testimonials yet. Only approved reviews should be added.</p></section>
    @else
        <div class="admin-cards">
            @foreach ($testimonials as $testimonial)
                <a class="admin-panel admin-quote" href="{{ route('admin.testimonials.edit', $testimonial) }}">
                    <div class="admin-quote-top">
                        <x-admin-status :status="$testimonial->is_published ? 'published' : 'draft'" :label="$testimonial->is_published ? 'Published' : 'Hidden'" />
                        @if ($testimonial->is_featured)<span class="sample-badge featured-badge">Homepage</span>@endif
                        @if ($testimonial->is_sample)<span class="sample-badge">Sample</span>@endif
                        <small>{{ ucfirst($testimonial->context) }}</small>
                    </div>
                    <p>“{{ \Illuminate\Support\Str::limit($testimonial->quote, 180) }}”</p>
                    <footer><span class="admin-avatar">@if ($testimonial->portraitUrl())<img src="{{ $testimonial->portraitUrl() }}" alt="">@else{{ mb_substr($testimonial->name, 0, 1) }}@endif</span><span><strong>{{ $testimonial->name }}</strong><small>{{ $testimonial->attribution() }}</small></span></footer>
                </a>
            @endforeach
        </div>
        {{ $testimonials->links('partials.pager') }}
    @endif
</x-admin-layout>
