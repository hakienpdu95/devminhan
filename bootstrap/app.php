<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \Modules\Core\Security\SecurityHeadersMiddleware::class,
            \Modules\Core\Security\RateLimitMiddleware::class,
            // Apply default theme to every web request; per-route groups override with theme:luxury etc.
            \Modules\Theme\Http\Middleware\ResolveThemeMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
