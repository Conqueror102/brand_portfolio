<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CohortController extends Controller
{
    public const FIELDS = ['mentorship_status', 'mentorship_cohort', 'mentorship_year', 'mentorship_timezone', 'mentorship_period', 'mentorship_duration', 'mentorship_opening', 'mentorship_sessions', 'mentorship_closing', 'mentorship_fee', 'mentorship_capacity', 'mentorship_delivery', 'applications_open_on', 'applications_close_on'];

    public function edit(): View
    {
        return view('admin.cohort', [
            'values' => collect(self::FIELDS)->mapWithKeys(fn ($key) => [$key => Setting::get($key)]),
            'effective' => mentorship_status(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mentorship_status' => ['required', 'in:forthcoming,open,closed,in_progress'],
            'mentorship_cohort' => ['required', 'string', 'max:60'],
            'mentorship_year' => ['nullable', 'string', 'max:20'],
            'mentorship_timezone' => ['nullable', 'string', 'max:60'],
            'mentorship_period' => ['nullable', 'string', 'max:80'],
            'mentorship_duration' => ['nullable', 'string', 'max:60'],
            'mentorship_opening' => ['nullable', 'string', 'max:120'],
            'mentorship_sessions' => ['nullable', 'string', 'max:120'],
            'mentorship_closing' => ['nullable', 'string', 'max:120'],
            'mentorship_fee' => ['nullable', 'string', 'max:60'],
            'mentorship_capacity' => ['nullable', 'string', 'max:60'],
            'mentorship_delivery' => ['nullable', 'string', 'max:160'],
            'applications_open_on' => ['nullable', 'date'],
            'applications_close_on' => ['nullable', 'date', 'after_or_equal:applications_open_on'],
        ]);

        Setting::put(array_map(fn ($value) => $value ?? '', $data));

        return to_route('admin.cohort.edit')->with('status', 'Cohort details saved. The website now shows: '.mentorship_status_label().'.');
    }
}
