<header class="theme-default__header bg-white shadow-sm">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
            {{ config('app.name') }}
        </a>

        @if(!empty($menu))
        <nav class="flex gap-6">
            @foreach($menu as $item)
            <a href="{{ $item['url'] ?? '#' }}" class="text-gray-600 hover:text-gray-900">
                {{ $item['label'] ?? '' }}
            </a>
            @endforeach
        </nav>
        @endif
    </div>
</header>
