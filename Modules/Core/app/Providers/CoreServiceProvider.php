<?php

namespace Modules\Core\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\Core\Api\SanctumApiClient;
use Modules\Core\Bff\Aggregators\PageDataAggregator;
use Modules\Core\Caching\CacheManager;

class CoreServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Core';
    protected string $nameLower = 'core';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function register(): void
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'core');

        $this->app->singleton(SanctumApiClient::class);
        $this->app->singleton(CacheManager::class);
        $this->app->singleton(PageDataAggregator::class);
    }

    public function boot(): void
    {
        parent::boot();

        $this->registerMiddleware();
    }

    private function registerMiddleware(): void
    {
        $router = $this->app['router'];

        $router->aliasMiddleware('security.headers', \Modules\Core\Security\SecurityHeadersMiddleware::class);
        $router->aliasMiddleware('api.token', \Modules\Core\Security\ApiTokenValidationMiddleware::class);
        $router->aliasMiddleware('throttle.frontend', \Modules\Core\Security\RateLimitMiddleware::class);
    }
}
