<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Core\Api\Exceptions\ApiException;
use Modules\Core\Api\SanctumApiClient;

// Home — fetches survey schema server-side, passes to view
Route::get('/', function (SanctumApiClient $client) {
    try {
        $response = $client->get('api/v1/surveys/ai-readiness-workflow/schema');
        $schema   = $response->success ? $response->data : null;
    } catch (ApiException) {
        $schema = null;
    }

    $submitUrl = $schema ? route('survey.submit', $schema['slug']) : null;

    return view('home', compact('schema', 'submitUrl'));
});

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
    ]);

    try {
        $crm = $client->post("api/v1/surveys/{$slug}/submit", $validated);
    } catch (ApiException $e) {
        return response()->json(['success' => false, 'message' => 'Không thể kết nối đến CRM. Vui lòng thử lại.'], 503);
    }

    return response()->json($crm->toArray(), $crm->statusCode);
})->name('survey.submit');

// Blog + Contact → luxury theme
Route::middleware('theme:luxury')->group(function () {
    Route::get('/blog', fn () => view('blog.index'));
    Route::get('/contact', fn () => view('contact'));
});
