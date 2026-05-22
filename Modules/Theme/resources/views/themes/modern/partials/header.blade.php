<header class="theme-modern__header sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-screen-xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="{{ url('/') }}" class="font-semibold text-lg tracking-tight text-gray-900">
            {{ config('app.name') }}
        </a>

        @if(!empty($menu))
        <nav class="flex gap-8 text-sm font-medium text-gray-600">
            @foreach($menu as $item)
            <a href="{{ $item['url'] ?? '#' }}" class="hover:text-blue-600 transition-colors">
                {{ $item['label'] ?? '' }}
            </a>
            @endforeach
        </nav>
        @endif
    </div>
</header>
