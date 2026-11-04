<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('admin.team', ['users' => User::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        User::create($request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:254', 'unique:users,email'],
            'role' => ['required', Rule::in(array_keys(config('site.roles')))],
            'password' => ['required', Password::defaults(), 'min:10'],
        ]));

        return back()->with('status', 'Team member added. Share their password with them securely.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['team' => 'You cannot remove your own account.']);
        }
        if ($user->hasRole('owner') && User::where('role', 'owner')->count() === 1) {
            return back()->withErrors(['team' => 'At least one owner account is required.']);
        }
        $user->delete();

        return back()->with('status', 'Team member removed.');
    }
}
