<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $enquiries = $this->query($request)->with('assignee')->latest()->paginate(20)->withQueryString();

        return view('admin.enquiries.index', [
            'enquiries' => $enquiries,
            'team' => User::orderBy('name')->get(),
            'dueCount' => Enquiry::whereNotNull('follow_up_on')->whereDate('follow_up_on', '<=', today())->whereNotIn('status', ['completed', 'declined', 'archived'])->count(),
        ]);
    }

    public function show(Enquiry $enquiry): View
    {
        if ($enquiry->status === 'new') {
            $enquiry->update(['status' => 'reviewing']);
            $enquiry->log('Opened and moved to Reviewing.');
        }

        return view('admin.enquiries.show', [
            'enquiry' => $enquiry->load('notes.user', 'assignee'),
            'team' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(config('site.enquiry_statuses')))],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'follow_up_on' => ['nullable', 'date'],
            'scheduled_for' => ['nullable', 'date'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $before = $enquiry->only(['status', 'assigned_to', 'follow_up_on', 'scheduled_for']);
        $enquiry->update($data);
        $this->logChanges($enquiry, $before);

        return back()->with('status', 'Enquiry updated.');
    }

    public function note(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $enquiry->log($request->validate(['body' => ['required', 'string', 'max:5000']])['body'], false);

        return back()->with('status', 'Note added.');
    }

    public function export(Request $request): StreamedResponse
    {
        $columns = ['created_at', 'type', 'status', 'name', 'email', 'phone', 'organisation', 'proposed_date', 'location', 'audience', 'participants', 'follow_up_on', 'scheduled_for', 'message'];
        $rows = $this->query($request)->oldest()->get();

        return response()->streamDownload(function () use ($columns, $rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, [...$columns, 'assigned_to']);
            foreach ($rows as $e) {
                fputcsv($out, [...array_map(fn ($c) => (string) $e->{$c}, $columns), (string) $e->assignee?->name]);
            }
            fclose($out);
        }, 'enquiries-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv']);
    }

    /** @return Builder<Enquiry> */
    private function query(Request $request): Builder
    {
        return Enquiry::query()
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($request->query('type'), fn ($q, $type) => $q->where('type', $type))
            ->when($request->query('assigned') === 'me', fn ($q) => $q->where('assigned_to', auth()->id()))
            ->when($request->query('assigned') === 'none', fn ($q) => $q->whereNull('assigned_to'))
            ->when($request->query('due'), fn ($q) => $q->whereNotNull('follow_up_on')->whereDate('follow_up_on', '<=', today())->whereNotIn('status', ['completed', 'declined', 'archived']));
    }

    /** @param array<string, mixed> $before */
    private function logChanges(Enquiry $enquiry, array $before): void
    {
        if ($before['status'] !== $enquiry->status) {
            $enquiry->log('Status changed to '.config('site.enquiry_statuses.'.$enquiry->status).'.');
        }
        if ($before['assigned_to'] != $enquiry->assigned_to) {
            $enquiry->log($enquiry->assigned_to ? 'Assigned to '.$enquiry->assignee()->value('name').'.' : 'Unassigned.');
        }
        if ((string) $before['follow_up_on'] !== (string) $enquiry->follow_up_on && $enquiry->follow_up_on) {
            $enquiry->log('Follow-up set for '.$enquiry->follow_up_on->format('j F Y').'.');
        }
        if ((string) $before['scheduled_for'] !== (string) $enquiry->scheduled_for && $enquiry->scheduled_for) {
            $enquiry->log('Scheduled for '.$enquiry->scheduled_for->format('j F Y').'.');
        }
    }
}
