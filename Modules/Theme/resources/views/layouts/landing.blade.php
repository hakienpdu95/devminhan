{{--
    Layout: landing — full-bleed marketing / campaign pages.
    Transparent sticky navbar over edge-to-edge content; no container clamp on
    the main region (sections manage their own width). Works under any theme.
--}}
@extends('theme::base.document')

@section('body')
    <div class="flex min-h-screen flex-col">
        @include('theme::partials.navbar')

        <main id="main-content" class="flex-1">
            @yield('content')
        </main>

        @include('theme::partials.footer')
    </div>
@endsection
