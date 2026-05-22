<?php

namespace Modules\Core\Caching;

use Illuminate\Support\Facades\Cache;

class CacheManager
{
    /**
     * Flush all BFF-related cache.
     */
    public function flushBff(): void
    {
        Cache::tags(['bff'])->flush();
    }

    /**
     * Flush cache for a specific module tag (e.g. 'blog', 'pages').
     */
    public function flushTag(string $tag): void
    {
        Cache::tags([$tag])->flush();
    }

    /**
     * Flush a single cache key across given tags.
     */
    public function forget(string $key, array $tags = ['bff']): void
    {
        Cache::tags($tags)->forget($key);
    }

    /**
     * Warm cache by running a callable and storing the result.
     */
    public function warm(string $key, callable $callback, int $ttl = 300, array $tags = ['bff']): mixed
    {
        return Cache::tags($tags)->remember($key, $ttl, $callback);
    }

    /**
     * Check if a cache key exists.
     */
    public function has(string $key, array $tags = ['bff']): bool
    {
        return Cache::tags($tags)->has($key);
    }
}
