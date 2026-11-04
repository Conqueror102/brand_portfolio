@extends('mail.layout')
@section('body')
    <h1 style="font-family:Georgia,serif;font-weight:normal;font-size:26px;margin:0 0 20px;">{{ $heading }}</h1>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        @foreach ($lines as $label => $value)
            <tr><td style="padding:8px 0;border-bottom:1px solid #EEE;color:#526170;font-size:12px;text-transform:uppercase;letter-spacing:.08em;width:130px;vertical-align:top;">{{ $label }}</td><td style="padding:8px 0;border-bottom:1px solid #EEE;">{!! nl2br(e(\Illuminate\Support\Str::limit((string) $value, 600))) !!}</td></tr>
        @endforeach
    </table>
    <p style="margin:28px 0 0;"><a href="{{ $link }}" style="display:inline-block;background:#102440;color:#FFFFFF;text-decoration:none;padding:12px 22px;border-radius:99px;">Open in the admin</a></p>
@endsection
