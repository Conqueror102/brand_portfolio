<?php

namespace App\Http\Controllers;

use App\Mail\NewSubmission;
use App\Models\Enquiry;
use App\Support\Notifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Bots fill the hidden field; show the normal confirmation without storing anything.
        if (filled($request->input('website'))) {
            return back()->with('enquiry_saved', true);
        }

        $data = $request->validate([
            'type' => ['required', Rule::in(array_keys(config('site.enquiry_types')))],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['nullable', 'string', 'max:40'],
            'organisation' => ['nullable', 'string', 'max:200'],
            'proposed_date' => ['nullable', 'string', 'max:60'],
            'location' => ['nullable', 'string', 'max:150'],
            'audience' => ['nullable', 'string', 'max:200'],
            'participants' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $enquiry = Enquiry::create($data);

        // Saved first; email problems are logged and never lose the enquiry.
        Notifier::send(new NewSubmission('enquiry', $enquiry));
        Notifier::receipt($enquiry->email, 'We have received your request', [
            'Thank you for getting in touch.',
            (string) content('contact.success'),
        ]);

        return back()->with('enquiry_saved', true);
    }
}
