@if (page_live('book'))
<section class="home-book wrap section-tight" id="book" aria-labelledby="book-title">
    <div class="card card-sand home-book-card" data-reveal>
        @include('partials.book-cover')
        <div class="home-book-copy">
            <p class="eyebrow">{{ content('navigation.book_label') }} · {{ content('book.release') }}</p>
            <h2 id="book-title" class="display h-md">{{ content('book.title') }}</h2>
            <p class="body-copy">{{ content('home.book_text') }}</p>
            <ul class="tags">
                @foreach (items('book_themes')->take(5) as $theme)<li class="tag">{{ $theme->title }}</li>@endforeach
            </ul>
            <div class="actions">
                @if (content('book.order_link'))
                    <a class="btn" href="{{ content_url('book.order_link') }}">{{ content('book.order_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                @else
                    <a class="btn" href="{{ route('book') }}#waitlist">Join the waiting list <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
                @endif
                <a class="link-arrow" href="{{ route('book') }}">About the book <x-line-icon name="arrow" /></a>
            </div>
        </div>
    </div>
</section>
@endif
