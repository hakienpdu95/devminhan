<?php

namespace Modules\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Theme\Actions\ResolveThemeAction;
use Symfony\Component\HttpFoundation\Response;

/**
 * Shares the resolved theme + layout with every Blade view in the request.
 *
 * Route usage:
 *   Route::middleware('theme:luxury')              // color theme only
 *   Route::middleware('theme:luxury,landing')      // color theme + layout
 *   Route::middleware('theme:,landing')            // layout only (default theme)
 *
 * Shared variables:
 *   $theme       string  active DaisyUI data-theme value
 *   $themes      array   selectable themes for the switcher
 *   $themeMaster string  layout master view path (for @extends)
 */
class ResolveThemeMiddleware
{
    public function __construct(
        private readonly ResolveThemeAction $resolveTheme,
    ) {}

    public function handle(Request $request, Closure $next, string $pageTheme = '', string $layout = ''): Response
    {
        $theme = $this->resolveTheme->handle($request, $pageTheme ?: null);

        view()->share('theme', $theme);
        view()->share('themes', $this->resolveTheme->themes());
        view()->share('themeMaster', $this->resolveTheme->layoutMaster($layout ?: null));
        // True khi route ép buộc theme — ngăn localStorage override server-set theme
        view()->share('themeForced', $pageTheme !== '' && $this->resolveTheme->isForced($pageTheme));

        return $next($request);
    }
}
