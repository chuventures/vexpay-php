<?php

declare(strict_types=1);

namespace VexPay;

use VexPay\Exception\UnexpectedResponseException;

/**
 * Base of every generated response model: typed readonly properties plus the raw decoded
 * response, so fields newer than this SDK stay reachable through toArray().
 */
abstract class Model implements \JsonSerializable
{
    /** @var array<string, mixed> */
    private array $raw = [];

    /**
     * @param array<string, mixed> $data
     */
    abstract public static function fromArray(array $data): static;

    /**
     * The response exactly as decoded, including fields this SDK version does not model.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->raw;
    }

    /**
     * @param array<string, mixed> $raw
     */
    protected function withRaw(array $raw): static
    {
        $this->raw = $raw;

        return $this;
    }

    /**
     * @param array<string, mixed> $data
     */
    protected static function required(array $data, string $key): mixed
    {
        if (!array_key_exists($key, $data) || $data[$key] === null) {
            throw new UnexpectedResponseException(
                sprintf('VEXPay response for %s is missing required field "%s".', static::class, $key),
                body: $data,
            );
        }

        return $data[$key];
    }

    /**
     * @template T of Model
     *
     * @param class-string<T> $class
     *
     * @return list<T>
     */
    protected static function listOf(string $class, mixed $items): array
    {
        if (!is_array($items)) {
            return [];
        }

        return array_values(array_map(static fn (array $item) => $class::fromArray($item), $items));
    }

    /**
     * @template E of \BackedEnum
     *
     * @param class-string<E> $enum
     *
     * @return E|string|int|null
     */
    protected static function enumOrRaw(string $enum, mixed $value): \BackedEnum|string|int|null
    {
        if ($value === null) {
            return null;
        }

        return $enum::tryFrom($value) ?? $value;
    }
}
