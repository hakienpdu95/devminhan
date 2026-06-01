{{--
    Layout: app — standard portal shell.
    navbar (sticky) + centered container + footer. Works under any theme.
--}}
@extends('theme::base.document')

@section('body')
    <div class="flex min-h-screen flex-col">
        @include('theme::partials.navbar')

        <main id="main-content" class="container mx-auto flex-1 px-4 py-8 lg:py-12">
            @yield('content')
        </main>

        @include('theme::partials.footer')
    </div>
@endsection
