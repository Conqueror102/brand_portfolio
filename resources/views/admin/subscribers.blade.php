<x-admin-layout title="Subscribers">
    <x-slot:actions><a class="btn btn-plain btn-outline" href="{{ route('admin.subscribers.export', request()->only('interest')) }}"><x-line-icon name="download" /> Export CSV</a></x-slot:actions>
    <p class="admin-intro">{{ $active }} active {{ \Illuminate\Support\Str::plural('subscriber', $active) }} from the newsletter sign-up in the footer. Export by interest to send updates from your email tool.</p>
    <form class="admin-filters" method="GET">
        <select name="interest" onchange="this.form.submit()" aria-label="Filter by interest">
            <option value="">All interests</option>
            @foreach (config('site.interests') as $value => $label)<option value="{{ $value }}" @selected(request('interest') === $value)>{{ $label }}</option>@endforeach
        </select>
        <select name="status" onchange="this.form.submit()" aria-label="Filter by status">
            <option value="">Everyone</option>
            <option value="active" @selected(request('status') === 'active')>Subscribed</option>
            <option value="unsubscribed" @selected(request('status') === 'unsubscribed')>Unsubscribed</option>
        </select>
        <noscript><button class="btn btn-plain" type="submit">Filter</button></noscript>
    </form>
    <section class="admin-panel admin-table-panel">
        @if ($subscribers->isEmpty())
            <p class="admin-empty">No subscribers yet.</p>
        @else
            <table class="admin-table">
                <thead><tr><th>Subscriber</th><th>Interests</th><th>Status</th><th>Joined</th><th><span class="sr-only">Actions</span></th></tr></thead>
                <tbody>
                @foreach ($subscribers as $subscriber)
                    <tr>
                        <td><span class="admin-cell-title"><span class="admin-avatar">{{ mb_strtoupper(mb_substr($subscriber->name ?: $subscriber->email, 0, 1)) }}</span><span><strong>{{ $subscriber->name ?: $subscriber->email }}</strong>@if ($subscriber->name)<small>{{ $subscriber->email }}</small>@endif</span></span></td>
                        <td>{{ collect($subscriber->interests ?? [])->map(fn ($i) => config('site.interests.'.$i, $i))->join(', ') ?: '—' }}</td>
                        <td><x-admin-status :status="$subscriber->unsubscribed_at ? 'archived' : 'published'" :label="$subscriber->unsubscribed_at ? 'Unsubscribed' : 'Subscribed'" /></td>
                        <td>{{ ($subscriber->consented_at ?? $subscriber->created_at)->format('j M Y') }}</td>
                        <td class="admin-row-actions"><form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}" data-confirm="Remove {{ $subscriber->email }} permanently?">@csrf @method('DELETE')<button class="admin-link-danger" type="submit">Remove</button></form></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
    {{ $subscribers->links('partials.pager') }}
</x-admin-layout>
