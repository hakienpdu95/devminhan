<?php

namespace Modules\Core\Security;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Validates that the CRM API token is configured before any outbound API call.
 * Blocks the request early rather than failing mid-render.
 */
class ApiTokenValidationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (empty(config('bff.crm_api_token'))) {
            Log::critical('CRM API token is not configured', ['route' => $request->path()]);

            abort(503, 'Service temporarily unavailable.');
        }

        return $next($request);
    }
}
