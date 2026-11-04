<x-layouts.page :title="content('navigation.work_label')" :description="content('work.meta')">
    <section class="wrap work-page-hero">
        <p class="eyebrow" data-reveal>{{ content('work.eyebrow') }}</p>
        <h1 class="display h-xxl">{{ content_html('work.title') }}</h1>
        <p class="lede" data-reveal>{{ content('work.lede') }}</p>
    </section>

    @if (items('proof_stats')->isNotEmpty())
        <section class="wrap work-page-stats" aria-label="Results">
            @foreach (items('proof_stats')->skip(1)->take(4) as $stat)
                <div data-reveal><strong class="proof-figure" data-count="{{ $stat->title }}">{{ $stat->title }}</strong><span>{{ $stat->subtitle }}</span></div>
            @endforeach
        </section>
    @endif

    <section class="wrap section-tight work-page-list">
        <x-work-list :cases="$cases" />
    </section>

    <x-site.cta :title="content('work.cta_title')" type="advisory" eyebrow="Work with Modupe" />
</x-layouts.page>
