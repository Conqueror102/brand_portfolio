<x-admin-layout title="Team">
    <div class="admin-form-grid">
        <section class="admin-panel admin-table-panel">
            <table class="admin-table">
                <thead><tr><th>Member</th><th>Role</th><th><span class="sr-only">Actions</span></th></tr></thead>
                <tbody>
                @foreach ($users as $member)
                    <tr>
                        <td><span class="admin-cell-title"><span class="admin-avatar">{{ mb_substr($member->name, 0, 1) }}</span><span><strong>{{ $member->name }} @if ($member->is(auth()->user()))<small class="admin-tag">You</small>@endif</strong><small>{{ $member->email }}</small></span></span></td>
                        <td><x-admin-status :status="$member->role === 'owner' ? 'published' : 'reviewing'" :label="ucfirst($member->role)" /></td>
                        <td class="admin-cell-actions">
                            @unless ($member->is(auth()->user()))
                                <form method="POST" action="{{ route('admin.team.destroy', $member) }}" data-confirm="Remove {{ $member->name }} from the team?">@csrf @method('DELETE')<button type="submit" class="admin-link-danger">Remove</button></form>
                            @endunless
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
        <aside class="admin-form-side">
            <form class="admin-panel form" method="POST" action="{{ route('admin.team.store') }}">
                @csrf
                <header><h2>Add a team member</h2></header>
                <x-field name="name" label="Name" required />
                <x-field name="email" label="Email" type="email" required />
                <div class="field">
                    <span>Role</span>
                    <div class="choice-group">
                        @foreach (config('site.roles') as $value => $label)
                            <label class="choice"><input type="radio" name="role" value="{{ $value }}" @checked(old('role', 'editor') === $value)> {{ $label }}</label>
                        @endforeach
                    </div>
                </div>
                <x-field name="password" label="Temporary password" type="password" required autocomplete="new-password" hint="At least 10 characters. They can change it under My account." />
                <button class="btn" type="submit">Add member <span class="btn-icon"><x-line-icon name="plus" /></span></button>
            </form>
        </aside>
    </div>
</x-admin-layout>
