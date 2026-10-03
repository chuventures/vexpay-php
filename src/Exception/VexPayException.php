<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * Base of every exception the SDK throws. Catch this to handle any VEXPay failure.
 */
class VexPayException extends \RuntimeException
{
    public function __construct(
        string $message,
        private readonly ?int $status = null,
        private readonly ?string $errorCode = null,
        private readonly mixed $body = null,
        private readonly ?string $requestId = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }

    /** HTTP status, when the API answered. */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /** Machine-readable API code, e.g. `insufficient_balance`. */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /** Decoded response body, when the API answered. */
    public function getBody(): mixed
    {
        return $this->body;
    }

    /** Value of the `x-request-id` response header, when present. */
    public function getRequestId(): ?string
    {
        return $this->requestId;
    }
}
