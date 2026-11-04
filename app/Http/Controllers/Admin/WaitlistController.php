<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaitlistSignup;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WaitlistController extends Controller
{
    public function index(): View
    {
        return view('admin.waitlist.index', ['signups' => WaitlistSignup::latest()->paginate(30)]);
    }

    public function export(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['created_at', 'name', 'email', 'format', 'marketing_consent']);
            WaitlistSignup::oldest()->each(fn ($s) => fputcsv($out, [(string) $s->created_at, $s->name, $s->email, $s->format, $s->marketing_consent ? 'yes' : 'no']));
            fclose($out);
        }, 'book-waitlist-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv']);
    }
}
