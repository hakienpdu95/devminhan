<?php

namespace Modules\Core\Caching;

use Illuminate\Support\Facades\Cache;

class CacheManager
{
    /**
     * True when the current cache driver supports Cache::tags().
     * Production should use Redis/Memcached for tag support.
     */
    public function supportsTags(): bool
    {
        return method_exists(Cache::getStore(), 'tags');
    }

    /**
     * Flush all BFF-related cache.
     */
    public function flushBff(): void
    {
        if (! $this->supportsTags()) {
            return;
        }

        Cache::tags(['bff'])->flush();
    }

    /**
     * Flush cache for a specific tag (e.g. 'blog', 'pages').
     */
    public function flushTag(string $tag): void
    {
        if (! $this->supportsTags()) {
            return;
        }

        Cache::tags([$tag])->flush();
    }

    /**
     * Flush a single cache key.
     */
    public function forget(string $key, array $tags = ['bff']): void
    {
        if (! $this->supportsTags()) {
            Cache::forget($key);
            return;
        }

        Cache::tags($tags)->forget($key);
    }

    /**
     * Warm cache by running a callable and storing the result.
     */
    public function warm(string $key, callable $callback, int $ttl = 300, array $tags = ['bff']): mixed
    {
        if (! $this->supportsTags()) {
            return Cache::remember($key, $ttl, $callback);
        }

        return Cache::tags($tags)->remember($key, $ttl, $callback);
    }

    /**
     * Check if a cache key exists.
     */
    public function has(string $key, array $tags = ['bff']): bool
    {
        if (! $this->supportsTags()) {
            return Cache::has($key);
        }

        return Cache::tags($tags)->has($key);
    }
}
