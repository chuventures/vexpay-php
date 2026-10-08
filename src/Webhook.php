<?php

declare(strict_types=1);

namespace VexPay;

use VexPay\Exception\SignatureVerificationException;
use VexPay\Webhook\WebhookEvent;

/**
 * Verify VEXPay webhook deliveries (`VexPay-Signature: t=<unix>,v1=<hex hmac>`). No API calls.
 */
final class Webhook
{
    public const SIGNATURE_HEADER = 'VexPay-Signature';
    public const EVENT_ID_HEADER = 'VexPay-Event-Id';
    public const DEFAULT_TOLERANCE = 300;

    public const EVENT_NAMES = [
        'payment.pending',
        'payment.completed',
        'payment.failed',
        'payment.canceled',
        'payment.reversed',
        'payment.chargeback',
        'payment.chargeback_closed',
        'merchant.verified',
        'merchant.rejected',
        'merchant.deactivated',
        'merchant.reactivated',
        'merchant.balance.updated',
        'merchant.created',
        'merchant.activated',
        'merchant.updated',
        'merchant.kyb_required',
        'merchant.restricted',
        'merchant.capability.updated',
        'merchant.wallet_credit',
        'payout.completed',
        'payout.failed',
        'conversion.completed',
        'conversion.canceled',
        'tenant.status_changed',
        'tenant.api_key.created',
        'tenant.api_key.rotated',
        'tenant.api_key.revoked',
        'tenant.live_status_changed',
        'notification.test',
    ];

    private const RAW_BODY_HINT = 'Pass the raw request body exactly as received. Decoding and re-encoding JSON — '
        . 'e.g. json_encode($request->all()) — changes the bytes and breaks the signature. '
        . "Use file_get_contents('php://input') or, in Laravel, \$request->getContent().";

    /**
     * Verifies a delivery and returns the parsed event.
     *
     * @param string $payload the raw request body
     * @param string|list<string>|null $signatureHeader value of the `VexPay-Signature` header
     * @param int $tolerance seconds; 0 disables the timestamp check
     * @param int|null $now unix time override (tests)
     *
     * @throws SignatureVerificationException on a bad signature or a timestamp outside tolerance (possible replay)
     */
    public static function constructEvent(
        string $payload,
        string|array|null $signatureHeader,
        string $secret,
        int $tolerance = self::DEFAULT_TOLERANCE,
        ?int $now = null,
    ): WebhookEvent {
        if ($secret === '') {
            throw new SignatureVerificationException('A webhook signing secret is required.');
        }
        $header = is_array($signatureHeader) ? ($signatureHeader[0] ?? null) : $signatureHeader;
        $parsed = is_string($header) && $header !== '' ? self::parseHeader($header) : null;
        if ($parsed === null) {
            throw new SignatureVerificationException(sprintf(
                'Unable to parse the %s header. Expected "t=<timestamp>,v1=<signature>".',
                self::SIGNATURE_HEADER,
            ));
        }
        [$timestamp, $signatures] = $parsed;
        if ($signatures === []) {
            throw new SignatureVerificationException(sprintf('No v1 signatures found in the %s header.', self::SIGNATURE_HEADER));
        }

        $current = $now ?? time();
        if ($tolerance > 0 && abs($current - $timestamp) > $tolerance) {
            throw new SignatureVerificationException(sprintf(
                'Webhook timestamp is outside the %ds tolerance — possible replay. Check your server clock if this repeats.',
                $tolerance,
            ));
        }

        $expected = self::sign($secret, $timestamp, $payload);
        $matched = false;
        foreach ($signatures as $candidate) {
            // Compare every candidate (no early exit) to keep timing independent of which one matches.
            $matched = hash_equals($expected, $candidate) || $matched;
        }
        if (!$matched) {
            throw new SignatureVerificationException(
                'No signature matches the expected signature for this payload. Check the endpoint secret. ' . self::RAW_BODY_HINT
            );
        }

        try {
            $decoded = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new SignatureVerificationException('Webhook payload is not valid JSON.', previous: $exception);
        }
        if (!is_array($decoded) || !isset($decoded['event']) || !is_string($decoded['event'])) {
            throw new SignatureVerificationException('Webhook payload is not a VEXPay event envelope.');
        }

        return WebhookEvent::fromArray($decoded);
    }

    /**
     * Builds a valid `VexPay-Signature` value — for your own tests.
     */
    public static function generateTestHeader(string $payload, string $secret, ?int $timestamp = null): string
    {
        $timestamp ??= time();

        return sprintf('t=%d,v1=%s', $timestamp, self::sign($secret, $timestamp, $payload));
    }

    private static function sign(string $secret, int $timestamp, string $payload): string
    {
        return hash_hmac('sha256', $timestamp . '.' . $payload, $secret);
    }

    /**
     * @return array{0: int, 1: list<string>}|null
     */
    private static function parseHeader(string $header): ?array
    {
        $timestamp = null;
        $signatures = [];
        foreach (explode(',', $header) as $part) {
            $index = strpos($part, '=');
            if ($index === false || $index === 0) {
                return null;
            }
            $key = trim(substr($part, 0, $index));
            $value = trim(substr($part, $index + 1));
            if ($key === '') {
                return null;
            }
            if ($key === 't') {
                $timestamp = $value;
            } elseif ($key === 'v1') {
                $signatures[] = $value;
            }
            // Unknown schemes (v0, future v2…) are ignored.
        }
        if ($timestamp === null || preg_match('/^\d+$/', $timestamp) !== 1) {
            return null;
        }

        return [(int) $timestamp, $signatures];
    }
}
