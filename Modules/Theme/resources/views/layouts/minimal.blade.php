{{--
    Layout: minimal — bare centered shell.
    No navbar/footer chrome — auth screens, standalone forms, embeds.
    A small floating theme switcher stays available. Works under any theme.
--}}
@extends('theme::base.document')

@section('body')
    <div class="relative flex min-h-screen flex-col items-center justify-center bg-base-200 px-4 py-10">
        <div class="absolute right-4 top-4">
            @include('theme::partials.theme-switcher')
        </div>

        <main id="main-content" class="w-full max-w-md">
            @yield('content')
        </main>
    </div>
@endsection
