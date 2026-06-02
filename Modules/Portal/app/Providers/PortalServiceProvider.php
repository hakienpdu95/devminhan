<?php

namespace Modules\Portal\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;

class PortalServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Portal';
    protected string $nameLower = 'portal';

    protected array $providers = [
        RouteServiceProvider::class,
    ];

    public function register(): void
    {
        parent::register();
    }

    public function boot(): void
    {
        parent::boot();
    }
}
