@extends('theme::base.document')

@section('body_class', 'theme-modern')

@section('body')
    <div class="theme-modern min-h-screen flex flex-col">
        @include('theme::themes.modern.partials.header')

        <main id="main-content" class="flex-1 max-w-screen-xl mx-auto w-full px-6 py-12">
            @yield('content')
        </main>

        @include('theme::themes.modern.partials.footer')
    </div>
@endsection
