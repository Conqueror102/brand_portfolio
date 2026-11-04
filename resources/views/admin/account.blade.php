<x-admin-layout title="My account">
    <div class="admin-form-grid">
        <section class="admin-panel">
            <div class="admin-cell-title"><span class="admin-avatar admin-avatar-lg">{{ mb_substr(auth()->user()->name, 0, 1) }}</span><span><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->email }} · {{ config('site.roles.'.auth()->user()->role) }}</small></span></div>
        </section>
        <form class="admin-panel form" method="POST" action="{{ route('admin.account.update') }}">
            @csrf @method('PUT')
            <header><h2>Change password</h2></header>
            <label class="field"><span>Current password</span><input type="password" name="current_password" autocomplete="current-password" required></label>
            <label class="field"><span>New password</span><input type="password" name="password" autocomplete="new-password" required minlength="10"></label>
            <label class="field"><span>Confirm new password</span><input type="password" name="password_confirmation" autocomplete="new-password" required></label>
            <button class="btn" type="submit">Update password <span class="btn-icon"><x-line-icon name="check" /></span></button>
        </form>
    </div>
</x-admin-layout>
