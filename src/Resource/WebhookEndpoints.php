<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;

/**
 * Where VEXPay delivers signed webhooks.
 */
final class WebhookEndpoints extends AbstractResource
{
    /**
     * The response includes the signing `secret` — store it to verify deliveries.
     *
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function create(array $params, array $options = []): M\WebhookEndpointDto
    {
        return $this->model('Webhooks_createWebhook', M\WebhookEndpointDto::class, body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return list<M\WebhookEndpointDto>
     */
    public function list(array $options = []): array
    {
        return $this->models('Webhooks_listWebhooks', M\WebhookEndpointDto::class, options: $options);
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $options
     */
    public function update(string $id, array $params, array $options = []): M\WebhookEndpointDto
    {
        return $this->model('Webhooks_updateWebhook', M\WebhookEndpointDto::class, ['id' => $id], body: $params, options: $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function delete(string $id, array $options = []): M\DeleteWebhookResponseDto
    {
        return $this->model('Webhooks_deleteWebhook', M\DeleteWebhookResponseDto::class, ['id' => $id], options: $options);
    }

    /**
     * Send a `notification.test` delivery to your endpoints.
     *
     * @param array<string, mixed> $options
     */
    public function sendTest(array $options = []): M\NotificationTestResponseDto
    {
        return $this->model('Notifications_sendTest', M\NotificationTestResponseDto::class, options: $options);
    }
}
