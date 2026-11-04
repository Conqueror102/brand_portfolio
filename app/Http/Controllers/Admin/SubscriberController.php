<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $subscribers = $this->query($request)->latest()->paginate(30)->withQueryString();

        return view('admin.subscribers', [
            'subscribers' => $subscribers,
            'active' => Subscriber::active()->count(),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $rows = $this->query($request)->whereNull('unsubscribed_at')->latest()->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Email', 'Name', 'Interests', 'Subscribed', 'Unsubscribe link']);
            foreach ($rows as $s) {
                fputcsv($out, [$s->email, $s->name, implode(', ', $s->interests ?? []), $s->consented_at?->format('Y-m-d'), route('unsubscribe', $s->token)]);
            }
            fclose($out);
        }, 'subscribers-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv']);
    }

    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return back()->with('status', 'Subscriber removed.');
    }

    /** @return Builder<Subscriber> */
    private function query(Request $request): Builder
    {
        return Subscriber::query()
            ->when($request->query('interest'), fn ($q, $interest) => $q->whereJsonContains('interests', $interest))
            ->when($request->query('status') === 'unsubscribed', fn ($q) => $q->whereNotNull('unsubscribed_at'))
            ->when($request->query('status') === 'active', fn ($q) => $q->whereNull('unsubscribed_at'));
    }
}
