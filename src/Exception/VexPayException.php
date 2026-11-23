<?php

declare(strict_types=1);

namespace VexPay\Exception;

/**
 * Base of every exception the SDK throws. Catch this to handle any VEX Pay failure.
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
        private readonly ?string $docUrl = null,
    ) {
        parent::__construct($message, 0, $previous);
    }

    /** HTTP status, when the API answered. */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Stable API code: the body's `code` (e.g. `insufficient_balance`, `validation_failed`, or an
     * uppercase risk or bank code such as `CARD_VELOCITY_BLOCKED`), else a lowercase `error`.
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /** Docs page for the code, e.g. `https://docs.vexpay.app/errors#insufficient_balance`, when the API sent one. */
    public function getDocUrl(): ?string
    {
        return $this->docUrl;
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
