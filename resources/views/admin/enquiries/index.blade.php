<x-admin-layout title="Enquiries">
    <x-slot:actions><a class="btn btn-plain btn-outline" href="{{ route('admin.enquiries.export', request()->only('status', 'type', 'assigned', 'due')) }}"><x-line-icon name="download" /> Export CSV</a></x-slot:actions>
    @if ($dueCount)
        <a class="alert alert-info admin-flash" href="{{ route('admin.enquiries.index', ['due' => 1]) }}"><x-line-icon name="clock" /> <span>{{ $dueCount }} {{ \Illuminate\Support\Str::plural('enquiry', $dueCount) }} due for follow-up. Show them.</span></a>
    @endif
    <form class="admin-filters" method="GET">
        <select name="status" onchange="this.form.submit()" aria-label="Filter by status">
            <option value="">All statuses</option>
            @foreach (config('site.enquiry_statuses') as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach
        </select>
        <select name="type" onchange="this.form.submit()" aria-label="Filter by type">
            <option value="">All types</option>
            @foreach (config('site.enquiry_types') as $value => $label)<option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>@endforeach
        </select>
        <select name="assigned" onchange="this.form.submit()" aria-label="Filter by assignee">
            <option value="">Anyone</option>
            <option value="me" @selected(request('assigned') === 'me')>Assigned to me</option>
            <option value="none" @selected(request('assigned') === 'none')>Unassigned</option>
        </select>
        @if (request('due'))<input type="hidden" name="due" value="1"><a class="link-arrow" href="{{ route('admin.enquiries.index') }}">Clear follow-up filter</a>@endif
        <noscript><button class="btn btn-plain" type="submit">Filter</button></noscript>
    </form>
    <section class="admin-panel admin-table-panel">
        @if ($enquiries->isEmpty())
            <p class="admin-empty">No enquiries match. New requests from the contact form appear here.</p>
        @else
            <table class="admin-table">
                <thead><tr><th>From</th><th>Request</th><th>Status</th><th>Owner</th><th>Received</th></tr></thead>
                <tbody>
                @foreach ($enquiries as $enquiry)
                    <tr class="{{ $enquiry->status === 'new' ? 'is-unread' : '' }}">
                        <td><a class="admin-cell-title" href="{{ route('admin.enquiries.show', $enquiry) }}"><span class="admin-avatar">{{ mb_substr($enquiry->name, 0, 1) }}</span><span><strong>{{ $enquiry->name }}</strong><small>{{ $enquiry->organisation ?: $enquiry->email }}</small></span></a></td>
                        <td>{{ $enquiry->typeLabel() }}</td>
                        <td><x-admin-status :status="$enquiry->status" :label="config('site.enquiry_statuses.'.$enquiry->status)" /></td>
                        <td>{{ $enquiry->assignee?->name ?? '—' }}@if ($enquiry->follow_up_on)<small class="admin-due {{ $enquiry->follow_up_on->isPast() || $enquiry->follow_up_on->isToday() ? 'is-due' : '' }}">Follow up {{ $enquiry->follow_up_on->format('j M') }}</small>@endif</td>
                        <td>{{ $enquiry->created_at->format('j M Y, H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
    {{ $enquiries->links('partials.pager') }}
</x-admin-layout>
