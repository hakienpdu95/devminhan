<?php

return [
    'crm_base_url' => env('CRM_BASE_URL', ''),
    'crm_api_token' => env('CRM_API_TOKEN', ''),
    'timeout'              => env('CRM_TIMEOUT',              10),
    'page_timeout'         => env('CRM_PAGE_TIMEOUT',          3),   // schema fetch trang chủ
    'retry_times'          => env('CRM_RETRY_TIMES',           2),
    'retry_ms'             => env('CRM_RETRY_MS',            500),
    'schema_cache_minutes' => env('CRM_SCHEMA_CACHE_MINUTES', 10),   // cache schema (0 = tắt)
];
