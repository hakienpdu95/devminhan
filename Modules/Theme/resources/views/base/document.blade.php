<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- SEO --}}
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="robots" content="@yield('meta_robots', 'index,follow')">

    {{-- Open Graph --}}
    @hasSection('og_title')
    <meta property="og:title" content="@yield('og_title')">
    <meta property="og:description" content="@yield('og_description', '')">
    <meta property="og:image" content="@yield('og_image', '')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    @endif

    {{-- Canonical --}}
    @hasSection('canonical')
    <link rel="canonical" href="@yield('canonical')">
    @endif

    @yield('head_extra')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="@yield('body_class', '')">

    @yield('body')

    @stack('scripts')
</body>
</html>
