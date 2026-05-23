<?php

namespace Modules\Core\Api;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Core\Api\DTO\ApiResponse;
use Modules\Core\Api\Exceptions\ApiException;

class SanctumApiClient
{
    private string $baseUrl;
    private string $token;
    private int $timeout;
    private int $retryTimes;
    private int $retryMs;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('bff.crm_base_url', ''), '/');
        $this->token = config('bff.crm_api_token', '');
        $this->timeout = config('bff.timeout', 10);
        $this->retryTimes = config('bff.retry_times', 2);
        $this->retryMs = config('bff.retry_ms', 500);
    }

    public function get(string $endpoint, array $params = []): ApiResponse
    {
        return $this->request('get', $endpoint, $params);
    }

    public function post(string $endpoint, array $data = []): ApiResponse
    {
        return $this->request('post', $endpoint, $data);
    }

    /**
     * Execute multiple GET requests concurrently via Http::pool().
     * Returns array of ApiResponse keyed by the same keys as $requests.
     *
     * @param array<string, string> $requests  key => endpoint
     */
    public function pool(array $requests): array
    {
        $results = Http::pool(function (Pool $pool) use ($requests) {
            foreach ($requests as $key => $endpoint) {
                $pool->as($key)
                    ->withToken($this->token)
                    ->acceptJson()
                    ->timeout($this->timeout)
                    ->get($this->url($endpoint));
            }
        });

        $responses = [];
        foreach ($requests as $key => $endpoint) {
            $response = $results[$key];

            if ($response instanceof \Throwable) {
                Log::warning('BFF pool request failed', ['key' => $key, 'endpoint' => $endpoint]);
                $responses[$key] = ApiResponse::error('Request failed', 503);
                continue;
            }

            $responses[$key] = $this->parseResponse($response, $endpoint);
        }

        return $responses;
    }

    private function request(string $method, string $endpoint, array $payload = []): ApiResponse
    {
        $url = $this->url($endpoint);

        try {
            $http = Http::withToken($this->token)
                ->acceptJson()
                ->timeout($this->timeout)
                ->retry(
                    $this->retryTimes,
                    $this->retryMs,
                    fn ($e) => $e instanceof \Illuminate\Http\Client\ConnectionException,
                    false
                );

            /** @var Response $response */
            $response = match ($method) {
                'get' => $http->get($url, $payload),
                'post' => $http->post($url, $payload),
                default => throw new \InvalidArgumentException("Unsupported method: {$method}"),
            };

            return $this->parseResponse($response, $endpoint);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('CRM API connection failed', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
            ]);
            throw ApiException::connectionFailed($endpoint, $e);
        }
    }

    private function parseResponse(Response $response, string $endpoint): ApiResponse
    {
        if ($response->status() === 401) {
            throw ApiException::unauthorized($endpoint);
        }

        if ($response->failed()) {
            Log::warning('CRM API returned error', [
                'endpoint' => $endpoint,
                'status'   => $response->status(),
            ]);
        }

        $body = $response->json() ?? [];

        return ApiResponse::from(is_array($body) ? $body : ['data' => $body], $response->status());
    }

    private function url(string $endpoint): string
    {
        return $this->baseUrl . '/' . ltrim($endpoint, '/');
    }
}
