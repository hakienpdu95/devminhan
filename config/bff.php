<?php

return [
    'crm_base_url' => env('CRM_BASE_URL', ''),
    'crm_api_token' => env('CRM_API_TOKEN', ''),
    'timeout' => env('CRM_TIMEOUT', 10),
    'retry_times' => env('CRM_RETRY_TIMES', 2),
    'retry_ms' => env('CRM_RETRY_MS', 500),
];
