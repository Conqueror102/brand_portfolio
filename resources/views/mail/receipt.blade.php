@extends('mail.layout')
@section('body')
    @foreach ($paragraphs as $paragraph)
        <p style="margin:0 0 14px;">{{ $paragraph }}</p>
    @endforeach
    <p style="margin:24px 0 0;color:#526170;">You do not need to reply to this email.</p>
@endsection
