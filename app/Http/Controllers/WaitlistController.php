<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WaitlistSignup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        abort_unless(Setting::flag('book_waitlist_open'), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:254'],
            'format' => ['required', 'in:print,digital,either'],
        ]);

        // Signing up twice simply updates the existing entry.
        WaitlistSignup::updateOrCreate(
            ['email' => strtolower($data['email'])],
            ['name' => $data['name'], 'format' => $data['format'], 'marketing_consent' => $request->boolean('marketing_consent')],
        );

        return back()->withFragment('waitlist')->with('waitlist_saved', true);
    }
}
