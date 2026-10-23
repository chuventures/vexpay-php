<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

/**
 * Hosted domiciliación setup links: send the customer to `url` to authorize automatic charges.
 */
final class SetupSessions extends AbstractResource
{
    /**
     * Expires in 24 h. `url` is returned only here.
     *
     * @param array<string, mixed> $params `customer`, optional `successUrl`
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\SetupSessionResponseDto
    {
        return $this->model('SetupSessions_create', M\SetupSessionResponseDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function retrieve(string $id, array $options = []): M\SetupSessionResponseDto
    {
        return $this->model('SetupSessions_retrieve', M\SetupSessionResponseDto::class, ['id' => $id], options: $options);
    }
}
