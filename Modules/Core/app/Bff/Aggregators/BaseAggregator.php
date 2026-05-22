<?php

namespace Modules\Core\Bff\Aggregators;

use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use Modules\Core\Api\SanctumApiClient;

abstract class BaseAggregator
{
    public function __construct(
        protected readonly SanctumApiClient $client,
    ) {}

    /**
     * Cache TTL in seconds — override per aggregator.
     */
    protected int $cacheTtl = 300;

    /**
     * Cache tags — override to add domain-specific tags.
     * @return string[]
     */
    protected function cacheTags(): array
    {
        return ['bff'];
    }

    protected function remember(string $key, callable $callback): mixed
    {
        $store = Cache::getStore();

        // Gracefully degrade if the active cache driver doesn't support tags
        // (e.g. file/database). Production should use redis/memcached.
        if (! method_exists($store, 'tags')) {
            return Cache::remember($key, $this->cacheTtl, $callback);
        }

        return Cache::tags($this->cacheTags())
            ->remember($key, $this->cacheTtl, $callback);
    }

    protected function forget(string $key): void
    {
        $store = Cache::getStore();

        if (! method_exists($store, 'tags')) {
            Cache::forget($key);
            return;
        }

        Cache::tags($this->cacheTags())->forget($key);
    }

    protected function flush(): void
    {
        $store = Cache::getStore();

        if (! method_exists($store, 'tags')) {
            return;
        }

        Cache::tags($this->cacheTags())->flush();
    }

    /**
     * Validate & sanitize a slug-like input before sending to CRM.
     * Accepts ASCII letters, digits, dash, underscore. Max 120 chars.
     * Throws if invalid — never trust upstream data in URLs.
     */
    protected function sanitizeSlug(string $value, string $field = 'slug'): string
    {
        $trimmed = trim($value);

        if ($trimmed === '' || strlen($trimmed) > 120) {
            throw new InvalidArgumentException("Invalid {$field}: length out of bounds.");
        }

        if (! preg_match('/^[a-zA-Z0-9_\-]+$/', $trimmed)) {
            throw new InvalidArgumentException("Invalid {$field}: only [a-zA-Z0-9_-] allowed.");
        }

        return $trimmed;
    }

    /**
     * Validate a positive integer ID.
     */
    protected function sanitizeId(int|string $value, string $field = 'id'): int
    {
        if (! is_numeric($value) || (int) $value < 1) {
            throw new InvalidArgumentException("Invalid {$field}: must be a positive integer.");
        }

        return (int) $value;
    }
}
