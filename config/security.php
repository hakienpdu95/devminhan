<?php

return [
    'hsts_enabled' => env('SECURITY_HSTS', false),

    // CSP is built dynamically in SecurityHeadersMiddleware (includes per-request nonce).
    // Override individual directives via env if needed; the middleware is the source of truth.

    'rate_limit' => [
        'per_minute' => env('RATE_LIMIT_PER_MINUTE', 60),
        'burst' => env('RATE_LIMIT_BURST', 10),
    ],
];
