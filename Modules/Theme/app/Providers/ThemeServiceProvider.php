<?php

namespace Modules\Theme\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\Theme\Actions\ResolveThemeAction;

class ThemeServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Theme';
    protected string $nameLower = 'theme';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function register(): void
    {
        parent::register();

        $this->app->singleton(ResolveThemeAction::class);
    }

    public function boot(): void
    {
        parent::boot();

        $this->registerThemeViews();
        $this->registerMiddleware();
    }

    private function registerThemeViews(): void
    {
        $viewsPath = module_path('Theme', 'resources/views');

        // Register theme:: namespace — nwidart does this automatically,
        // but we ensure the override path is checked first.
        $overridesPath = $viewsPath . '/overrides';

        if (is_dir($overridesPath)) {
            $this->app['view']->prependNamespace('theme', $overridesPath);
        }

        // Allow other modules to override theme views by placing files in
        // resources/views/vendor/theme/ within the main app resources.
        $appOverride = resource_path('views/vendor/theme');
        if (is_dir($appOverride)) {
            $this->app['view']->prependNamespace('theme', $appOverride);
        }
    }

    private function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware(
            'theme',
            \Modules\Theme\Http\Middleware\ResolveThemeMiddleware::class
        );
    }
}
