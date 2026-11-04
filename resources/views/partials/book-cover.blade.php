@if (content_image('book.cover'))
    <img class="book-cover-img {{ $large ?? false ? 'book-cover-lg' : '' }}" src="{{ content_image('book.cover') }}" alt="Cover of {{ content('book.title') }}">
@else
    <div class="book-cover {{ $large ?? false ? 'book-cover-lg' : '' }}" aria-hidden="true">
        <span class="book-cover-author">{{ content('profile.given_name') }} {{ content('profile.surname') }}</span>
        <span class="book-cover-rule"></span>
        <span class="book-cover-title">{!! str_replace(['<em>', '</em>'], ['<em>', '</em>'], content_html('book.cover_title')) !!}</span>
    </div>
@endif
