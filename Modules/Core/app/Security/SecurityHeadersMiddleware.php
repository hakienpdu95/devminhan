<?php

namespace Modules\Core\Security;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Per-request nonce — whitelists only our known inline scripts (e.g. the
        // anti-FOUC theme snippet in base/document.blade.php) without using
        // 'unsafe-inline', which would allow arbitrary injected scripts.
        $nonce = base64_encode(random_bytes(16));
        view()->share('cspNonce', $nonce);

        $response = $next($request);

        $csp = implode('; ', [
            "default-src 'self'",
            // 'unsafe-eval' needed by Alpine.js (uses new Function() internally).
            // nonce whitelists the anti-FOUC inline script only.
            "script-src 'self' 'unsafe-eval' 'nonce-{$nonce}'",
            // Google Fonts stylesheet served from fonts.googleapis.com.
            // 'unsafe-inline' needed for Tailwind/DaisyUI injected styles in dev.
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "img-src 'self' data: https:",
            // fonts.gstatic.com serves the actual font files.
            "font-src 'self' https://fonts.gstatic.com https:",
            "connect-src 'self'",
            "frame-ancestors 'none'",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        if (config('security.hsts_enabled', false)) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Remove fingerprinting headers
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
