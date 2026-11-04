<x-admin-layout title="Book waiting list">
    <x-slot:actions><a class="btn btn-plain btn-outline" href="{{ route('admin.waitlist.export') }}"><x-line-icon name="download" /> Export CSV</a></x-slot:actions>
    <section class="admin-panel admin-table-panel">
        @if ($signups->isEmpty())
            <p class="admin-empty">Nobody has joined yet. Sign-ups from the book page appear here.</p>
        @else
            <table class="admin-table">
                <thead><tr><th>Name</th><th>Email</th><th>Format</th><th>Updates</th><th>Joined</th></tr></thead>
                <tbody>
                @foreach ($signups as $signup)
                    <tr><td><strong>{{ $signup->name }}</strong></td><td><a href="mailto:{{ $signup->email }}">{{ $signup->email }}</a></td><td>{{ ucfirst($signup->format) }}</td><td>{{ $signup->marketing_consent ? 'Yes' : 'No' }}</td><td>{{ $signup->created_at->format('j M Y') }}</td></tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </section>
    {{ $signups->links('partials.pager') }}
</x-admin-layout>
