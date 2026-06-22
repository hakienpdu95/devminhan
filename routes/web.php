<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Modules\Core\Api\Exceptions\ApiException;
use Modules\Core\Api\SanctumApiClient;

// Khảo sát AI Readiness — di chuyển sang /khaosat
Route::middleware('theme:thuchoc,blank')->get('/khaosat', function (SanctumApiClient $client) {
    $cacheKey = 'survey.schema.ai-readiness-workflow';
    $cacheTtl = (int) config('bff.schema_cache_minutes', 10);

    // Đọc cache — chỉ gọi API khi cache miss
    $schema = $cacheTtl > 0 ? Cache::get($cacheKey) : null;

    if ($schema === null) {
        try {
            $response = $client->get(
                'api/v1/surveys/ai-readiness-workflow/schema',
                timeout:    config('bff.page_timeout', 3),
                retryTimes: 0,
            );
            if ($response->success && ! empty($response->data)) {
                $schema = $response->data;
                if ($cacheTtl > 0) {
                    Cache::put($cacheKey, $schema, now()->addMinutes($cacheTtl));
                }
            } else {
                // CRM trả về nhưng không success/data rỗng — log để biết status/message thật
                // thay vì chỉ thấy trang fallback "Chưa tải được dữ liệu khảo sát".
                Log::warning('survey.khaosat.schema_not_ok', [
                    'status'  => $response->statusCode,
                    'message' => $response->message,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('survey.khaosat.schema_fetch_exception', [
                'error' => $e->getMessage(),
            ]);
            $schema = null; // API lỗi/timeout → render fallback ngay
        }
    }

    $submitUrl = $schema ? route('survey.submit', $schema['slug']) : null;

    return view('ai-readiness', compact('schema', 'submitUrl'));
})->name('survey.khaosat');

// Survey submit proxy — keeps CRM token server-side
Route::post('/survey/{slug}/submit', function (Request $request, SanctumApiClient $client, string $slug) {
    $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $slug);
    abort_if(! $slug || strlen($slug) > 120, 400, 'Invalid slug.');

    $validated = $request->validate([
        'respondent_ref'            => ['nullable', 'string', 'max:255'],
        'answers'                   => ['required', 'array'],
        'answers.*.field_key'       => ['required', 'string', 'max:255'],
        'answers.*.value'           => ['present'],
        'answers.*.other_text'      => ['nullable', 'string', 'max:1000'],
        'cf-turnstile-response'     => ['nullable', 'string', 'max:2048'],
    ]);

    try {
        $crm = $client->post("api/v1/surveys/{$slug}/submit", $validated);
    } catch (ApiException $e) {
        Log::error('survey.submit.proxy_exception', [
            'slug'  => $slug,
            'error' => $e->getMessage(),
        ]);
        return response()->json(['success' => false, 'message' => 'Không thể kết nối đến CRM. Vui lòng thử lại.'], 503);
    }

    if ($crm->statusCode >= 400) {
        // Log kèm body thật từ CRM (vd lỗi validation/Turnstile cụ thể) — SanctumApiClient
        // chỉ log status code, không log nội dung lỗi.
        Log::warning('survey.submit.crm_rejected', [
            'slug'   => $slug,
            'status' => $crm->statusCode,
            'data'   => $crm->data,
        ]);
    }

    return response()->json($crm->toArray(), $crm->statusCode);
})->name('survey.submit');

// Survey result proxy — client polling để lấy kết quả chấm điểm từ CRM
Route::get('/survey/{slug}/result', function (Request $request, SanctumApiClient $client, string $slug) {
    $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $slug);
    abort_if(! $slug || strlen($slug) > 120, 400, 'Invalid slug.');

    $params = array_filter([
        'response_id' => $request->query('response_id') ? (int) $request->query('response_id') : null,
        'ref'         => $request->query('ref') ?: null,
    ]);

    try {
        $crm = $client->get("api/v1/surveys/{$slug}/result", $params, retryTimes: 0);
    } catch (ApiException $e) {
        Log::error('survey.result.proxy_exception', [
            'slug'  => $slug,
            'error' => $e->getMessage(),
        ]);
        return response()->json(['success' => false, 'message' => 'Không thể kết nối đến CRM.'], 503);
    }

    return response()->json($crm->toArray(), $crm->statusCode);
})->name('survey.result');

// Blog + Contact → luxury theme
Route::middleware('theme:luxury')->group(function () {
    Route::get('/blog', fn () => view('blog.index'));
    Route::get('/contact', fn () => view('contact'));
});
