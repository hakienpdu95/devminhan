@php($navItems = $menu ?? config('theme.nav', []))

<footer class="border-t border-base-300 bg-base-200/50 mt-auto">
    <div class="container mx-auto px-4 py-10">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-grid size-8 place-items-center rounded-lg bg-primary text-primary-content font-black">
                    {{ strtoupper(substr(config('app.name'), 0, 1)) }}
                </span>
                <div>
                    <div class="font-bold">{{ config('app.name') }}</div>
                    <div class="text-xs text-base-content/60">Cổng thông tin</div>
                </div>
            </div>

            <nav class="flex flex-wrap gap-x-6 gap-y-2 text-sm">
                @foreach($navItems as $item)
                    <a href="{{ $item['url'] ?? '#' }}" class="text-base-content/70 hover:text-primary transition-colors">
                        {{ $item['label'] ?? '' }}
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="divider my-6 opacity-50"></div>

        <p class="text-center text-xs text-base-content/50">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</footer>
