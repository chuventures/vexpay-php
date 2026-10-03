<?php

declare(strict_types=1);

namespace VexPay\Testing;

/**
 * One request the fake transport received, decoded.
 */
final class RecordedRequest
{
    /**
     * @param array<string, string>               $pathParams
     * @param array<string, string|list<string>>  $query
     * @param array<string, mixed>|null           $body
     * @param array<string, list<string>>         $headers
     */
    public function __construct(
        public readonly string $operationId,
        public readonly string $method,
        public readonly string $path,
        public readonly array $pathParams,
        public readonly array $query,
        public readonly ?array $body,
        public readonly array $headers,
    ) {
    }

    public function header(string $name): ?string
    {
        foreach ($this->headers as $key => $values) {
            if (strcasecmp($key, $name) === 0) {
                return $values[0] ?? null;
            }
        }

        return null;
    }
}
