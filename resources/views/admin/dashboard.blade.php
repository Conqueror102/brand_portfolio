<x-admin-layout title="Overview" :heading="'Good '.(now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening')).', '.explode(' ', auth()->user()->name)[0].'.'">
    @if ($samples && auth()->user()->can('manage-content'))
        <div class="alert alert-info admin-flash"><x-line-icon name="eye" /> <span>{{ $samples }} sample {{ \Illuminate\Support\Str::plural('item', $samples) }} (articles and testimonials marked “Sample”) are showing on the website. Edit or delete them before launch.</span></div>
    @endif

    @if ($unpublished && auth()->user()->can('manage-content'))
        <a class="alert alert-info admin-flash" href="{{ route('admin.pages.index') }}"><x-line-icon name="eye" /> <span>{{ $unpublished }} unpublished page {{ \Illuminate\Support\Str::plural('change', $unpublished) }} waiting. Review and publish.</span></a>
    @endif
    <section class="admin-stats">
        @can('manage-inbox')
            <a class="admin-stat admin-stat-navy" href="{{ route('admin.enquiries.index', ['status' => 'new']) }}"><x-line-icon name="inbox" /><strong>{{ $stats['newEnquiries'] }}</strong><span>New enquiries</span></a>
            <a class="admin-stat admin-stat-cream" href="{{ route('admin.applications.index') }}"><x-line-icon name="steps" /><strong>{{ $stats['pendingApplications'] }}</strong><span>Applications to review</span></a>
            <a class="admin-stat" href="{{ route('admin.waitlist.index') }}"><x-line-icon name="book" /><strong>{{ $stats['waitlist'] }}</strong><span>On the book waiting list</span></a>
            <a class="admin-stat" href="{{ route('admin.subscribers.index') }}"><x-line-icon name="mail" /><strong>{{ $subscribers }}</strong><span>Newsletter subscribers</span></a>
        @endcan
        @can('manage-content')
            <a class="admin-stat admin-stat-mist" href="{{ route('admin.articles.index') }}"><x-line-icon name="file" /><strong>{{ $stats['publishedArticles'] }}</strong><span>Published insights · {{ $stats['draftArticles'] }} drafts</span></a>
        @endcan
    </section>

    <div class="admin-grid">
        @can('manage-inbox')
            <section class="admin-panel">
                <header><h2>Latest enquiries</h2><a href="{{ route('admin.enquiries.index') }}">View all</a></header>
                @forelse ($recentEnquiries as $enquiry)
                    <a class="admin-row" href="{{ route('admin.enquiries.show', $enquiry) }}">
                        <span class="admin-avatar">{{ mb_substr($enquiry->name, 0, 1) }}</span>
                        <span class="admin-row-main"><strong>{{ $enquiry->name }}</strong><small>{{ $enquiry->typeLabel() }}</small></span>
                        <x-admin-status :status="$enquiry->status" :label="config('site.enquiry_statuses.'.$enquiry->status)" />
                        <small class="admin-row-date">{{ $enquiry->created_at->diffForHumans() }}</small>
                    </a>
                @empty
                    <p class="admin-empty">No enquiries yet. They appear here as soon as someone uses the contact form.</p>
                @endforelse
            </section>
            @if ($followUps->isNotEmpty())
                <section class="admin-panel">
                    <header><h2>Follow-ups this week</h2><a href="{{ route('admin.enquiries.index', ['due' => 1]) }}">Due now</a></header>
                    @foreach ($followUps as $enquiry)
                        <a class="admin-row" href="{{ route('admin.enquiries.show', $enquiry) }}">
                            <span class="admin-avatar">{{ mb_substr($enquiry->name, 0, 1) }}</span>
                            <span class="admin-row-main"><strong>{{ $enquiry->name }}</strong><small>{{ $enquiry->typeLabel() }}@if ($enquiry->assignee) · {{ $enquiry->assignee->name }}@endif</small></span>
                            <small class="admin-due {{ $enquiry->follow_up_on->isFuture() && ! $enquiry->follow_up_on->isToday() ? '' : 'is-due' }}">{{ $enquiry->follow_up_on->isToday() ? 'Today' : $enquiry->follow_up_on->format('j M') }}</small>
                        </a>
                    @endforeach
                </section>
            @endif
            <section class="admin-panel">
                <header><h2>Latest applications</h2><a href="{{ route('admin.applications.index') }}">View all</a></header>
                @forelse ($recentApplications as $application)
                    <a class="admin-row" href="{{ route('admin.applications.show', $application) }}">
                        <span class="admin-avatar">{{ mb_substr($application->name, 0, 1) }}</span>
                        <span class="admin-row-main"><strong>{{ $application->name }}</strong><small>{{ $application->role }}</small></span>
                        <x-admin-status :status="$application->status" :label="config('site.application_statuses.'.$application->status)" />
                        <small class="admin-row-date">{{ $application->created_at->diffForHumans() }}</small>
                    </a>
                @empty
                    <p class="admin-empty">No applications yet.</p>
                @endforelse
            </section>
        @endcan
        <section class="admin-panel admin-panel-navy">
            <header><h2>Mentorship programme</h2></header>
            <p class="admin-big">{{ mentorship_status_label() }}</p>
            <p class="admin-muted">{{ cohort('cohort') }}@if (cohort('applications_close_on')) · closes {{ nice_date(cohort('applications_close_on')) }}@endif</p>
            @can('manage-content')<a class="btn btn-light" href="{{ route('admin.cohort.edit') }}">Manage cohort <span class="btn-icon"><x-line-icon name="arrow" /></span></a>@endcan
        </section>
        @can('manage-content')
            <section class="admin-panel">
                <header><h2>Quick actions</h2></header>
                <div class="admin-quick">
                    <a href="{{ route('admin.articles.create') }}"><x-line-icon name="plus" /> Write an insight</a>
                    <a href="{{ route('admin.testimonials.create') }}"><x-line-icon name="quote" /> Add a testimonial</a>
                    <a href="{{ route('admin.pages.edit', 'home') }}"><x-line-icon name="home" /> Edit the homepage</a>
                    <a href="{{ route('admin.items.index', 'engagements') }}"><x-line-icon name="calendar" /> Add a speaking engagement</a>
                    <a href="{{ route('admin.media.index') }}"><x-line-icon name="download" /> Upload images or documents</a>
                    <a href="{{ route('insights.index') }}" target="_blank" rel="noopener"><x-line-icon name="eye" /> View insights page</a>
                </div>
            </section>
        @endcan
    </div>
</x-admin-layout>
