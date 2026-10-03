<?php

declare(strict_types=1);

namespace VexPay\Resource;

use VexPay\Exception\UnexpectedResponseException;
use VexPay\Generated\Routes;
use VexPay\Internal\Requester;
use VexPay\Model;
use VexPay\Pagination\CursorPage;

/**
 * @phpstan-type RequestOptions array{idempotency_key?: string, timeout?: int|float, max_network_retries?: int}
 */
abstract class AbstractResource
{
    public function __construct(protected readonly Requester $requester)
    {
    }

    /**
     * @param array<string, string> $path
     * @param array<string, mixed> $query
     * @param array<string, mixed> $options
     */
    protected function send(string $operationId, array $path = [], array $query = [], mixed $body = null, array $options = []): mixed
    {
        [$method, $template] = Routes::ROUTES[$operationId];

        return $this->requester->request($method, Requester::fillPath($template, $path), $query, $body, $options);
    }

    /**
     * @template T of Model
     *
     * @param class-string<T> $class
     * @param array<string, string> $path
     * @param array<string, mixed> $query
     * @param array<string, mixed> $options
     *
     * @return T
     */
    protected function model(string $operationId, string $class, array $path = [], array $query = [], mixed $body = null, array $options = []): Model
    {
        self::checkModel($operationId, $class);

        return self::hydrate($class, $this->send($operationId, $path, $query, $body, $options));
    }

    /**
     * @template T of Model
     *
     * @param class-string<T> $class
     * @param array<string, string> $path
     * @param array<string, mixed> $query
     * @param array<string, mixed> $options
     *
     * @return list<T>
     */
    protected function models(string $operationId, string $class, array $path = [], array $query = [], array $options = []): array
    {
        self::checkModel($operationId, $class);
        $raw = $this->send($operationId, $path, $query, null, $options);
        if (!is_array($raw) || !array_is_list($raw)) {
            throw new UnexpectedResponseException(sprintf('VEXPay %s did not return a list.', $operationId), body: $raw);
        }

        return array_map(static fn ($item) => self::hydrate($class, $item), $raw);
    }

    /**
     * @param array<string, string> $path
     * @param array<string, mixed> $options
     */
    protected function none(string $operationId, array $path = [], array $options = []): void
    {
        $this->send($operationId, $path, [], null, $options);
    }

    /**
     * @template P of Model
     *
     * @param class-string<P> $pageClass a list response with `items` and `nextCursor`
     * @param array<string, mixed> $query
     * @param array<string, mixed> $options
     */
    protected function page(string $operationId, string $pageClass, array $query = [], array $options = []): CursorPage
    {
        $fetch = function (?string $cursor) use ($operationId, $pageClass, $query, $options): Model {
            $query['cursor'] = $cursor;

            return self::hydrate($pageClass, $this->send($operationId, [], $query, null, $options));
        };
        $start = isset($query['cursor']) ? (string) $query['cursor'] : null;

        return new CursorPage($fetch, $start);
    }

    /**
     * @template T of Model
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    protected static function hydrate(string $class, mixed $data): Model
    {
        if (!is_array($data)) {
            throw new UnexpectedResponseException(
                sprintf('VEXPay response for %s is not a JSON object.', $class),
                body: $data,
            );
        }
        try {
            return $class::fromArray($data);
        } catch (\TypeError $error) {
            throw new UnexpectedResponseException(
                sprintf('VEXPay response does not match %s: %s', $class, $error->getMessage()),
                body: $data,
                previous: $error,
            );
        }
    }

    private static function checkModel(string $operationId, string $class): void
    {
        $expected = Routes::ROUTES[$operationId][2];
        $short = substr($class, (int) strrpos($class, '\\') + 1);
        if ($expected !== null && $expected !== $short) {
            throw new \LogicException(sprintf('%s returns %s, not %s.', $operationId, $expected, $short));
        }
    }
}
