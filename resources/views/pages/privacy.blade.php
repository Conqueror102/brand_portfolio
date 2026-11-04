<x-layouts.page title="Privacy notice" description="How information submitted through this website is used.">
    <section class="wrap page-hero-simple">
        <p class="eyebrow">Privacy · Updated {{ content('privacy.updated') }}</p>
        <h1 class="display h-lg">{{ content_html('privacy.title') }}</h1>
    </section>
    <section class="wrap section-tight">
        <div class="card card-white prose">{{ block_text(content('privacy.body')) }}</div>
    </section>
</x-layouts.page>
