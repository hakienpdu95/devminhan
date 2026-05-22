<header class="theme-luxury__header border-b border-stone-800">
    <div class="max-w-5xl mx-auto px-8 py-6 flex items-center justify-between">
        <a href="{{ url('/') }}" class="font-light text-2xl tracking-[0.2em] uppercase text-stone-100">
            {{ config('app.name') }}
        </a>

        @if(!empty($menu))
        <nav class="flex gap-10 text-xs tracking-widest uppercase text-stone-400">
            @foreach($menu as $item)
            <a href="{{ $item['url'] ?? '#' }}" class="hover:text-stone-100 transition-colors">
                {{ $item['label'] ?? '' }}
            </a>
            @endforeach
        </nav>
        @endif
    </div>
</header>
