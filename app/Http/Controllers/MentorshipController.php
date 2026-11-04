<?php

namespace App\Http\Controllers;

use App\Mail\NewSubmission;
use App\Models\MentorshipApplication;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Support\Notifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MentorshipController extends Controller
{
    public function show(): View
    {
        return view('pages.mentorship', [
            'status' => mentorship_status(),
            'cohort' => Setting::get('mentorship_cohort'),
            'deadline' => Setting::get('applications_close_on'),
            'testimonials' => Testimonial::published()->whereIn('context', ['mentorship', 'coaching'])->take(3)->get(),
        ]);
    }

    public function apply(Request $request): RedirectResponse
    {
        abort_unless(mentorship_status() === 'open', 403, 'Applications are not open.');

        if (filled($request->input('website'))) {
            return to_route('mentorship')->withFragment('apply')->with('application_saved', true);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['nullable', 'string', 'max:40'],
            'role' => ['required', 'string', 'max:200'],
            'location' => ['required', 'string', 'max:150'],
            'goals' => ['required', 'string', 'min:20', 'max:3000'],
            'outcomes' => ['required', 'string', 'min:20', 'max:3000'],
            'motivation' => ['required', 'string', 'min:20', 'max:3000'],
            'support' => ['nullable', 'string', 'max:3000'],
            'availability' => ['required', 'in:consistently,mostly,unsure'],
            'in_person' => ['required', 'in:yes,unsure,no'],
            'commitment' => ['required', 'string', 'min:20', 'max:3000'],
            'privacy' => ['accepted'],
        ], [
            'privacy.accepted' => 'Please confirm you have read how your application will be used.',
        ]);

        $application = MentorshipApplication::create([
            ...collect($data)->except('privacy')->all(),
            'cohort' => Setting::get('mentorship_cohort'),
            'marketing_consent' => $request->boolean('marketing_consent'),
            'privacy_consented_at' => now(),
        ]);

        // Saved first; email problems are logged and never lose the application.
        Notifier::send(new NewSubmission('application', $application));
        Notifier::receipt($application->email, 'Your mentorship application has been received', [
            'Thank you for applying to the Mentorship Programme.',
            (string) content('mentorship.apply_success'),
        ]);

        return to_route('mentorship')->withFragment('apply')->with('application_saved', true);
    }
}
