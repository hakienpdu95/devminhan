<?php

namespace Modules\Core\Queries;

use Illuminate\Support\Facades\Cache;

abstract class BaseQuery
{
    /**
     * Cache TTL in seconds. Set to 0 to disable caching.
     */
    protected int $cacheTtl = 300;

    /**
     * Cache tags for this query. Only used when the driver supports tagging
     * (redis/memcached); falls back to plain remember() otherwise.
     * @return string[]
     */
    protected function cacheTags(): array
    {
        return ['queries'];
    }

    /**
     * Unique cache key for this query instance.
     */
    abstract protected function cacheKey(): string;

    /**
     * Execute the query logic (typically calls a BFF Aggregator).
     */
    abstract protected function fetch(): mixed;

    public function get(): mixed
    {
        if ($this->cacheTtl === 0) {
            return $this->fetch();
        }

        $key = $this->cacheKey();
        $ttl = $this->cacheTtl;

        if (! method_exists(Cache::getStore(), 'tags')) {
            return Cache::remember($key, $ttl, fn () => $this->fetch());
        }

        return Cache::tags($this->cacheTags())
            ->remember($key, $ttl, fn () => $this->fetch());
    }
}
