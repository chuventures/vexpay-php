<?php

declare(strict_types=1);

namespace VexPay\Resource\Payments;

use VexPay\Generated\Models as M;
use VexPay\Resource\AbstractResource;

/**
 * Bank operation status for débito/crédito (advanced payments, enabled per account).
 */
final class Operations extends AbstractResource
{
    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\R4OperationResponseDto
    {
        return $this->model('R4Operations_consultarOperacion', M\R4OperationResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function poll(array $params, array $options = []): M\ManualOperationPollResponseDto
    {
        return $this->model('R4Operations_pollOperation', M\ManualOperationPollResponseDto::class, body: $params, options: $options);
    }
}
