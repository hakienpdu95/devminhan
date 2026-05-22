<?php

namespace Modules\Core\Api\DTO;

class ApiResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly mixed $data,
        public readonly int $statusCode,
        public readonly ?string $message = null,
        public readonly array $meta = [],
    ) {}

    public static function from(array $response, int $statusCode): self
    {
        $success = $statusCode >= 200 && $statusCode < 300;

        return new self(
            success: $success,
            data: $response['data'] ?? $response,
            statusCode: $statusCode,
            message: $response['message'] ?? null,
            meta: $response['meta'] ?? [],
        );
    }

    public static function error(string $message, int $statusCode): self
    {
        return new self(
            success: false,
            data: null,
            statusCode: $statusCode,
            message: $message,
        );
    }

    public function isOk(): bool
    {
        return $this->success;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'data' => $this->data,
            'status_code' => $this->statusCode,
            'message' => $this->message,
            'meta' => $this->meta,
        ];
    }
}
