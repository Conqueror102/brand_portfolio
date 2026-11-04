<x-layouts.page title="Unsubscribed" description="You have been unsubscribed.">
    <section class="wrap section">
        <div class="empty-state card card-mist-soft">
            <span class="success-icon"><x-line-icon name="check" /></span>
            <h1 class="display h-md">You have been unsubscribed.</h1>
            <p class="body-copy">You will not receive further updates. You can subscribe again at any time from the footer.</p>
            <a class="link-arrow" href="{{ route('home') }}">Back to the homepage <x-line-icon name="arrow" /></a>
        </div>
    </section>
</x-layouts.page>
