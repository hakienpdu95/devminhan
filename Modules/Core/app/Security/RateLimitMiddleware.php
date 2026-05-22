<?php

namespace Modules\Core\Security;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Two-axis rate limiter: per IP + per authenticated user.
 *
 * Usage:
 *   Route::middleware('throttle.frontend')->...
 *
 * Config: see config/security.php → rate_limit.
 */
class RateLimitMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $perMinute = (int) config('security.rate_limit.per_minute', 60);
        $burst     = (int) config('security.rate_limit.burst', 10);

        // IP-based limit (always applied)
        $ipKey = 'rl:ip:' . $request->ip();
        if (RateLimiter::tooManyAttempts($ipKey, $perMinute)) {
            return $this->tooManyRequests($ipKey);
        }
        RateLimiter::hit($ipKey, 60);

        // User-based limit (tighter, when authenticated)
        if ($userId = optional($request->user())->getAuthIdentifier()) {
            $userKey = 'rl:user:' . $userId;
            if (RateLimiter::tooManyAttempts($userKey, $perMinute + $burst)) {
                return $this->tooManyRequests($userKey);
            }
            RateLimiter::hit($userKey, 60);
        }

        return $next($request);
    }

    private function tooManyRequests(string $key): Response
    {
        $retry = RateLimiter::availableIn($key);

        return response('Too Many Requests', 429, [
            'Retry-After'         => (string) $retry,
            'X-RateLimit-Reset'   => (string) (time() + $retry),
        ]);
    }
}
