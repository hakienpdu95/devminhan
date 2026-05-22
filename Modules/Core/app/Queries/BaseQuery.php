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
     * Cache tags for this query. Must use tagged cache driver (Redis).
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
     * Execute the query logic against the CRM via Aggregator.
     */
    abstract protected function fetch(): mixed;

    public function get(): mixed
    {
        if ($this->cacheTtl === 0) {
            return $this->fetch();
        }

        return Cache::tags($this->cacheTags())
            ->remember($this->cacheKey(), $this->cacheTtl, fn () => $this->fetch());
    }
}
