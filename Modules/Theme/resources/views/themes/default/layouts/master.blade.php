@extends('theme::base.document')

@section('body')
    <div class="theme-default">
        @include('theme::themes.default.partials.header')

        <main id="main-content" class="container mx-auto px-4 py-8">
            @yield('content')
        </main>

        @include('theme::themes.default.partials.footer')
    </div>
@endsection
