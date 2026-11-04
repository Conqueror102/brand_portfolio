<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorshipApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $applications = $this->query($request)
            ->with('assignee')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.applications.index', [
            'applications' => $applications,
            'cohorts' => MentorshipApplication::distinct()->orderBy('cohort')->pluck('cohort'),
        ]);
    }

    public function show(MentorshipApplication $application): View
    {
        if ($application->status === 'submitted') {
            $application->update(['status' => 'reviewing']);
            $application->log('Opened and moved to Under review.');
        }

        return view('admin.applications.show', [
            'application' => $application->load('notes.user', 'assignee'),
            'team' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, MentorshipApplication $application): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(config('site.application_statuses')))],
            'payment_status' => ['required', Rule::in(array_keys(config('site.payment_statuses')))],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $before = $application->only(['status', 'payment_status', 'assigned_to']);
        $application->update($data);
        if ($before['status'] !== $application->status) {
            $application->log('Decision changed to '.config('site.application_statuses.'.$application->status).'.');
        }
        if ($before['payment_status'] !== $application->payment_status) {
            $application->log('Payment marked '.strtolower(config('site.payment_statuses.'.$application->payment_status)).'.');
        }
        if ($before['assigned_to'] != $application->assigned_to) {
            $application->log($application->assigned_to ? 'Assigned to '.$application->assignee()->value('name').'.' : 'Unassigned.');
        }

        return back()->with('status', 'Application updated. No email has been sent to the applicant.');
    }

    public function note(Request $request, MentorshipApplication $application): RedirectResponse
    {
        $application->log($request->validate(['body' => ['required', 'string', 'max:5000']])['body'], false);

        return back()->with('status', 'Note added.');
    }

    public function export(Request $request): StreamedResponse
    {
        $columns = ['created_at', 'cohort', 'name', 'email', 'phone', 'role', 'location', 'availability', 'in_person', 'status', 'payment_status', 'goals', 'outcomes', 'motivation', 'support', 'commitment', 'marketing_consent'];

        $rows = $this->query($request)->oldest()->get();

        return response()->streamDownload(function () use ($columns, $rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            $rows->each(fn ($a) => fputcsv($out, array_map(fn ($c) => (string) $a->{$c}, $columns)));
            fclose($out);
        }, 'mentorship-applications-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv']);
    }

    /** @return Builder<MentorshipApplication> */
    private function query(Request $request): Builder
    {
        return MentorshipApplication::query()
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($request->query('payment'), fn ($q, $payment) => $q->where('payment_status', $payment))
            ->when($request->query('cohort'), fn ($q, $cohort) => $q->where('cohort', $cohort));
    }
}
