<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Generated\Models as M;
use VexPay\Pagination\CursorPage;

/**
 * Where VEX Pay delivers signed webhooks.
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

    /**
     * One endpoint's deliveries, newest first: status (`pending`, `retrying`, `success`, `failed`),
     * attempts, the next automatic retry and your endpoint's last reply. Iterate for every delivery.
     *
     * @param array<string, mixed> $params `status`, `event`, `limit`, `cursor`
     * @param array<string, mixed> $options
     *
     * @return CursorPage items are M\WebhookDeliveryDto
     */
    public function listDeliveries(string $id, array $params = [], array $options = []): CursorPage
    {
        return $this->page('Webhooks_listDeliveries', M\WebhookDeliveryListDto::class, $params, $options, ['id' => $id]);
    }

    /**
     * Send a delivery again now, with the same body and `VexPay-Event-Id` (deduplicate on it).
     * A success clears any scheduled retry.
     *
     * @param array<string, mixed> $options
     */
    public function resendDelivery(string $id, string $deliveryId, array $options = []): M\WebhookDeliveryDto
    {
        return $this->model(
            'Webhooks_resendDelivery',
            M\WebhookDeliveryDto::class,
            ['id' => $id, 'deliveryId' => $deliveryId],
            options: $options,
        );
    }

    /**
     * Issue a new signing secret; `secret` is shown only in this response, so store it. The previous
     * secret keeps signing (a second `v1=` entry) for `expiresInHours` (0–168, default 24); pass 0 to
     * stop it at once after a leak.
     *
     * @param array<string, mixed> $params `expiresInHours`
     * @param array<string, mixed> $options
     */
    public function rotateSecret(string $id, array $params = [], array $options = []): M\RotateWebhookSecretResponseDto
    {
        return $this->model('Webhooks_rotateSecret', M\RotateWebhookSecretResponseDto::class, ['id' => $id], body: $params, options: $options);
    }
}
