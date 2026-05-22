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
     * Slug is sanitized to prevent path traversal / URL injection upstream.
     */
    public function getPage(string $slug): ApiResponse
    {
        $clean = $this->sanitizeSlug($slug, 'page slug');

        return $this->remember("bff:page:{$clean}", function () use ($clean) {
            return $this->client->get("api/pages/{$clean}");
        });
    }
}
