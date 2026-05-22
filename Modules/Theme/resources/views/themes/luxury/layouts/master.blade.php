@extends('theme::base.document')

@section('body_class', 'theme-luxury bg-stone-950 text-stone-100')

@section('body')
    <div class="theme-luxury min-h-screen flex flex-col">
        @include('theme::themes.luxury.partials.header')

        <main id="main-content" class="flex-1 max-w-5xl mx-auto w-full px-8 py-16">
            @yield('content')
        </main>

        @include('theme::themes.luxury.partials.footer')
    </div>
@endsection
