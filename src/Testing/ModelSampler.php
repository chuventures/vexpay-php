<?php

declare(strict_types=1);

namespace VexPay\Testing;

use VexPay\Model;

/**
 * Builds the smallest response body a generated model accepts — every required field with a
 * placeholder of the right type — optionally overlaid with values that fit the model.
 */
final class ModelSampler
{
    private int $sequence = 0;

    /**
     * @param class-string<Model>  $class
     * @param array<string, mixed> $overlay values to use where the model has a matching, type-compatible field
     *
     * @return array<string, mixed>
     */
    public function sample(string $class, array $overlay = []): array
    {
        $out = [];
        foreach ($this->parameters($class) as $parameter) {
            $name = $parameter->getName();
            $value = $overlay[$name] ?? null;
            if ((is_int($value) || is_float($value)) && !self::fits($parameter->getType(), $value)) {
                $value = (string) $value;
            }
            if (array_key_exists($name, $overlay) && self::fits($parameter->getType(), $value)) {
                $out[$name] = $value;
            } elseif (!$parameter->isOptional()) {
                $out[$name] = $this->placeholder($name, $parameter->getType());
            }
        }

        return $out;
    }

    /**
     * @param class-string<Model> $class
     *
     * @return list<\ReflectionParameter>
     */
    private function parameters(string $class): array
    {
        return (new \ReflectionClass($class))->getConstructor()?->getParameters() ?? [];
    }

    private function placeholder(string $name, ?\ReflectionType $type): mixed
    {
        foreach (self::named($type) as $named) {
            $typeName = $named->getName();
            if (is_subclass_of($typeName, \BackedEnum::class)) {
                return $typeName::cases()[0]->value;
            }
            if (is_subclass_of($typeName, Model::class)) {
                return $this->sample($typeName);
            }
        }

        return match (self::named($type)[0]?->getName()) {
            'string' => $this->string($name),
            'float' => 1.0,
            'int' => 1,
            'bool' => false,
            'array' => [],
            default => null,
        };
    }

    private function string(string $name): string
    {
        if ($name === 'id' || str_ends_with($name, 'Id')) {
            return sprintf('%s_fake_%d', $name, ++$this->sequence);
        }
        if (str_ends_with($name, 'At')) {
            return '2026-01-01T00:00:00.000Z';
        }
        if (str_ends_with(strtolower($name), 'url')) {
            return 'https://pay.vexwallet.co/fake';
        }
        if (preg_match('/amount|usd|ves|monto|rate|fee|balance|percent/i', $name) === 1) {
            return '1.00';
        }

        return 'fake';
    }

    private static function fits(?\ReflectionType $type, mixed $value): bool
    {
        if ($value === null) {
            return $type === null || $type->allowsNull();
        }
        foreach (self::named($type) as $named) {
            $ok = match ($named->getName()) {
                'string' => is_string($value),
                'float' => is_float($value) || is_int($value),
                'int' => is_int($value),
                'bool' => is_bool($value),
                'array' => is_array($value),
                'mixed' => true,
                default => false,
            };
            if ($ok) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<\ReflectionNamedType|null>
     */
    private static function named(?\ReflectionType $type): array
    {
        if ($type instanceof \ReflectionNamedType) {
            return [$type];
        }
        if ($type instanceof \ReflectionUnionType) {
            return array_values(array_filter(
                $type->getTypes(),
                static fn ($t) => $t instanceof \ReflectionNamedType && $t->getName() !== 'null',
            ));
        }

        return [null];
    }
}
