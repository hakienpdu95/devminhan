<?php

return [
    'hsts_enabled' => env('SECURITY_HSTS', false),

    // 'unsafe-eval' required for Alpine.js (uses new Function() to evaluate x-data expressions).
    // Inline scripts are avoided — all JS ships via the Vite bundle.
    'csp' => env(
        'SECURITY_CSP',
        "default-src 'self'; script-src 'self' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' https:;"
    ),

    'rate_limit' => [
        'per_minute' => env('RATE_LIMIT_PER_MINUTE', 60),
        'burst' => env('RATE_LIMIT_BURST', 10),
    ],
];
