<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-theme="{{ $theme ?? config('theme.default', 'brand-light') }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Anti-FOUC: apply the visitor's stored theme before first paint.
         The server already renders the cookie value; this only reconciles
         a localStorage choice made before the cookie round-tripped. --}}
    <script nonce="{{ $cspNonce ?? '' }}">
        (function () {
            @if(empty($themeForced))
            try {
                var t = localStorage.getItem('theme');
                if (t) document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
            @endif
        })();
    </script>

    {{-- SEO --}}
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="robots" content="@yield('meta_robots', 'index,follow')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    {{-- App shell: Tailwind v4 + DaisyUI (all themes) + Alpine --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen bg-base-100 text-base-content antialiased @yield('body_class')">

    @yield('body')

    @stack('scripts')
</body>
</html>
