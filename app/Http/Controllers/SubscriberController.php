<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SubscriberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if (filled($request->input('website'))) {
            return back()->withFragment('newsletter')->with('subscribed', true);
        }

        $data = $request->validateWithBag('newsletter', [
            'email' => ['required', 'email', 'max:254'],
            'interests' => ['nullable', 'array'],
            'interests.*' => [Rule::in(array_keys(config('site.interests')))],
        ]);

        $subscriber = Subscriber::firstOrNew(['email' => strtolower($data['email'])]);
        $subscriber->fill([
            'interests' => array_values(array_unique([...($subscriber->interests ?? []), ...($data['interests'] ?? ['insights'])])),
            'consented_at' => now(),
            'unsubscribed_at' => null,
        ])->save();

        return back()->withFragment('newsletter')->with('subscribed', true);
    }

    public function unsubscribe(string $token): View
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();
        $subscriber->update(['unsubscribed_at' => now()]);

        return view('pages.unsubscribed');
    }
}
