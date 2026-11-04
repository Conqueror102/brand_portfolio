<x-admin-layout title="Mentorship applications">
    <x-slot:actions><a class="btn btn-plain btn-outline" href="{{ route('admin.applications.export', request()->only('status', 'payment', 'cohort')) }}"><x-line-icon name="download" /> Export CSV</a></x-slot:actions>
    <nav class="admin-tabs">
        <a class="{{ request('status') ? '' : 'is-active' }}" href="{{ route('admin.applications.index') }}">All</a>
        @foreach (config('site.application_statuses') as $value => $label)
            <a class="{{ request('status') === $value ? 'is-active' : '' }}" href="{{ route('admin.applications.index', ['status' => $value]) }}">{{ $label }}</a>
        @endforeach
    </nav>
    <form class="admin-filters" method="GET">
        @if (request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        <select name="payment" onchange="this.form.submit()" aria-label="Filter by payment">
            <option value="">Any payment status</option>
            @foreach (config('site.payment_statuses') as $value => $label)<option value="{{ $value }}" @selected(request('payment') === $value)>{{ $label }}</option>@endforeach
        </select>
        <select name="cohort" onchange="this.form.submit()" aria-label="Filter by cohort">
            <option value="">All cohorts</option>
            @foreach ($cohorts as $cohort)<option value="{{ $cohort }}" @selected(request('cohort') === $cohort)>{{ $cohort }}</option>@endforeach
        </select>
        <noscript><button class="btn btn-plain" type="submit">Filter</button></noscript>
    </form>
    <section class="admin-panel admin-table-panel">
        @if ($applications->isEmpty())
            <p class="admin-empty">No applications here yet.</p>
        @else
            <table class="admin-table">
                <thead><tr><th>Applicant</th><th>Cohort</th><th>Status</th><th>Payment</th><th>Owner</th><th>Received</th></tr></thead>
                <tbody>
                @foreach ($applications as $application)
                    <tr class="{{ $application->status === 'submitted' ? 'is-unread' : '' }}">
                        <td><a class="admin-cell-title" href="{{ route('admin.applications.show', $application) }}"><span class="admin-avatar">{{ mb_substr($application->name, 0, 1) }}</span><span><strong>{{ $application->name }}</strong><small>{{ $application->role }} · {{ $application->location }}</small></span></a></td>
                        <td>{{ $application->cohort }}</td>
                        <td><x-admin-status :status="$application->status" :label="config('site.application_statuses.'.$application->status)" /></td>
                        <td><x-admin-status :status="$application->payment_status" :label="config('site.payment_statuses.'.$application->payment_status)" /></td>
                        <td>{{ $application->assignee?->name ?? '—' }}</td>
                        <td>{{ $application->created_at->format('j M Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
    {{ $applications->links('partials.pager') }}
</x-admin-layout>
