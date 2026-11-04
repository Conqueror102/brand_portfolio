<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = collect(['book_waitlist_open', 'notification_email', 'send_receipts', 'contact_email', 'linkedin_url', 'instagram_url'])->mapWithKeys(fn ($key) => [$key => Setting::get($key)]);

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'notification_email' => ['nullable', 'email', 'max:254'],
            'contact_email' => ['nullable', 'email', 'max:254'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
        ]);
        $data['book_waitlist_open'] = $request->boolean('book_waitlist_open');
        $data['send_receipts'] = $request->boolean('send_receipts');

        Setting::put($data);

        return back()->with('status', 'Settings saved.');
    }
}
