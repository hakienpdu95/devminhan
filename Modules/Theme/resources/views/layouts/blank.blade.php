{{--
    Layout: blank — document shell only.
    No navbar / footer chrome. Use when the page manages its own full-page UI
    (landing pages, embeds, custom-branded forms).
--}}
@extends('theme::base.document')

@section('body')
    @yield('content')
@endsection
