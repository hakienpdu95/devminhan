@php($navItems = $menu ?? config('theme.nav', []))

<header class="navbar bg-base-100/90 backdrop-blur border-b border-base-300 sticky top-0 z-40">
    <div class="container mx-auto px-4">

        {{-- Brand --}}
        <div class="navbar-start">
            {{-- Mobile menu --}}
            <div class="dropdown lg:hidden">
                <div tabindex="0" role="button" class="btn btn-ghost btn-square" aria-label="Menu">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </div>
                <ul tabindex="0" class="menu dropdown-content mt-3 z-50 w-52 rounded-box bg-base-100 p-2 shadow-lg">
                    @foreach($navItems as $item)
                        <li><a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] ?? '' }}</a></li>
                    @endforeach
                </ul>
            </div>

            <a href="{{ url('/') }}" class="btn btn-ghost text-xl font-bold normal-case gap-2">
                <span class="inline-grid size-7 place-items-center rounded-lg bg-primary text-primary-content text-sm font-black">
                    {{ strtoupper(substr(config('app.name'), 0, 1)) }}
                </span>
                {{ config('app.name') }}
            </a>
        </div>

        {{-- Desktop nav --}}
        <nav class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal gap-1 px-1">
                @foreach($navItems as $item)
                    <li><a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] ?? '' }}</a></li>
                @endforeach
            </ul>
        </nav>

        {{-- Actions --}}
        <div class="navbar-end gap-1">
            @include('theme::partials.theme-switcher')
            <a href="{{ url('/contact') }}" class="btn btn-primary btn-sm hidden sm:inline-flex">Bắt đầu</a>
        </div>
    </div>
</header>
