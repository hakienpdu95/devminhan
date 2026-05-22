<?php

namespace Modules\Core\Api\Exceptions;

use RuntimeException;

class ApiException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly int $statusCode = 500,
        public readonly ?string $endpoint = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    public static function connectionFailed(string $endpoint, \Throwable $previous): self
    {
        return new self(
            message: "Failed to connect to CRM API: {$endpoint}",
            statusCode: 503,
            endpoint: $endpoint,
            previous: $previous,
        );
    }

    public static function unauthorized(string $endpoint): self
    {
        return new self(
            message: "Unauthorized access to CRM API: {$endpoint}",
            statusCode: 401,
            endpoint: $endpoint,
        );
    }

    public static function notFound(string $endpoint): self
    {
        return new self(
            message: "Resource not found at: {$endpoint}",
            statusCode: 404,
            endpoint: $endpoint,
        );
    }
}
