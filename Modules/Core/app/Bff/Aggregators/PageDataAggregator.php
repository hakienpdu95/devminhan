<?php

namespace Modules\Core\Bff\Aggregators;

use Modules\Core\Api\DTO\ApiResponse;

/**
 * Aggregates multiple CRM API calls into one page payload via Http::pool().
 * Reduces N requests to 1 round-trip for common page data.
 */
class PageDataAggregator extends BaseAggregator
{
    protected int $cacheTtl = 600;

    protected function cacheTags(): array
    {
        return ['bff', 'pages'];
    }

    /**
     * Fetch menu + settings in a single pool call.
     */
    public function getGlobalData(): array
    {
        return $this->remember('bff:global', function () {
            $responses = $this->client->pool([
                'menu' => 'api/menu',
                'settings' => 'api/settings',
            ]);

            return [
                'menu' => $responses['menu']->isOk() ? $responses['menu']->data : [],
                'settings' => $responses['settings']->isOk() ? $responses['settings']->data : [],
            ];
        });
    }

    /**
     * Fetch page data by slug.
     */
    public function getPage(string $slug): ApiResponse
    {
        return $this->remember("bff:page:{$slug}", function () use ($slug) {
            return $this->client->get("api/pages/{$slug}");
        });
    }
}
