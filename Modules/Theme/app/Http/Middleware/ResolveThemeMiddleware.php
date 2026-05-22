<?php

namespace Modules\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Theme\Actions\ResolveThemeAction;
use Symfony\Component\HttpFoundation\Response;

class ResolveThemeMiddleware
{
    public function __construct(
        private readonly ResolveThemeAction $resolveTheme,
    ) {}

    public function handle(Request $request, Closure $next, string $pageTheme = ''): Response
    {
        $theme = $this->resolveTheme->handle($request, $pageTheme ?: null);

        // Share with all Blade views in this request
        view()->share('theme', $theme);
        view()->share('themeMaster', $this->resolveTheme->masterLayout($theme));

        return $next($request);
    }
}
