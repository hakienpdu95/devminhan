<?php

namespace Modules\Core\Bff\Aggregators;

use Illuminate\Support\Facades\Cache;
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
        return Cache::tags($this->cacheTags())
            ->remember($key, $this->cacheTtl, $callback);
    }

    protected function forget(string $key): void
    {
        Cache::tags($this->cacheTags())->forget($key);
    }

    protected function flush(): void
    {
        Cache::tags($this->cacheTags())->flush();
    }
}
