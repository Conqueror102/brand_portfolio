<?php

namespace App\Support;

use App\Mail\Receipt;
use App\Models\Setting;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Sends email after a submission has been saved. A mail failure is logged, never shown to the visitor,
 * and never loses the submission: everything is always in the admin.
 */
class Notifier
{
    public static function send(Mailable $mail): void
    {
        $to = Setting::get('notification_email');
        if (! $to) {
            return;
        }

        try {
            Mail::to($to)->send($mail);
        } catch (Throwable $e) {
            report($e);
        }
    }

    /** @param list<string> $paragraphs */
    public static function receipt(string $email, string $subject, array $paragraphs): void
    {
        if (! Setting::flag('send_receipts')) {
            return;
        }

        try {
            Mail::to($email)->send(new Receipt($subject, array_values(array_filter($paragraphs))));
        } catch (Throwable $e) {
            report($e);
        }
    }
}
