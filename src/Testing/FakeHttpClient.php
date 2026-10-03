<?php

declare(strict_types=1);

namespace VexPay\Testing;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use VexPay\Generated\Routes;
use VexPay\Model;

/**
 * In-memory PSR-18 transport for tests: no request leaves the process. Every VEXPay operation
 * answers with a valid body for its response model — required fields filled with placeholders,
 * overlaid with matching request fields (so `create()` echoes what you sent) — unless you stub it.
 *
 *     $http = new FakeHttpClient(['Payouts_create' => ['status' => 'completed']]);
 *     $vexpay = new VexPayClient(['api_key' => 'test', 'http_client' => $http]);
 */
final class FakeHttpClient implements ClientInterface
{
    /** @var array<string, array<string, mixed>> */
    private const DEFAULTS = [
        'CheckoutSessions_create' => ['clientSecret' => 'cs_secret_fake', 'livemode' => false],
    ];

    /** @var list<RecordedRequest> */
    private array $recorded = [];

    /** @var array<string, array<string, mixed>|callable|ResponseInterface> */
    private array $stubs = [];

    private ModelSampler $sampler;

    /**
     * @param array<string, array<string, mixed>|callable|ResponseInterface> $stubs keyed by operationId
     */
    public function __construct(array $stubs = [])
    {
        $this->sampler = new ModelSampler();
        foreach ($stubs as $operationId => $stub) {
            $this->stub($operationId, $stub);
        }
    }

    /**
     * Answer an operation with `$stub`: an array merged over the generated body, a
     * `callable(RecordedRequest): array|ResponseInterface`, or a full response (e.g. an error
     * built with `FakeHttpClient::error()`).
     *
     * @param array<string, mixed>|callable|ResponseInterface $stub
     */
    public function stub(string $operationId, array|callable|ResponseInterface $stub): self
    {
        if (!isset(Routes::ROUTES[$operationId])) {
            throw new \InvalidArgumentException(sprintf('Unknown VEXPay operationId "%s".', $operationId));
        }
        $this->stubs[$operationId] = $stub;

        return $this;
    }

    /**
     * An API error response, e.g. `FakeHttpClient::error(409, 'external_ref_conflict')`.
     */
    public static function error(int $status, string $code, ?string $message = null): ResponseInterface
    {
        return self::json(['statusCode' => $status, 'error' => $code, 'message' => $message ?? $code], $status);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $recorded = $this->record($request);
        if ($recorded === null) {
            return self::error(404, 'not_found', sprintf('No VEXPay route for %s %s.', $request->getMethod(), $request->getUri()->getPath()));
        }
        $this->recorded[] = $recorded;

        $stub = $this->stubs[$recorded->operationId] ?? [];
        if ($stub instanceof ResponseInterface) {
            return $stub;
        }
        if (is_callable($stub)) {
            $stub = $stub($recorded);
            if ($stub instanceof ResponseInterface) {
                return $stub;
            }
        }

        return $this->respond($recorded, $stub);
    }

    /**
     * @return list<RecordedRequest>
     */
    public function recorded(?string $operationId = null): array
    {
        return $operationId === null
            ? $this->recorded
            : array_values(array_filter($this->recorded, static fn (RecordedRequest $r) => $r->operationId === $operationId));
    }

    /**
     * @param array<string, mixed> $stub
     */
    private function respond(RecordedRequest $request, array $stub): ResponseInterface
    {
        [, $template, $model] = Routes::ROUTES[$request->operationId];

        if ($model === null) {
            if ($template === '/v1/merchants') {
                return isset($request->query['externalRef'])
                    ? self::json($this->body('MerchantResponseDto', $request, $stub))
                    : self::json(array_replace(['items' => [], 'nextCursor' => null], $stub));
            }

            return new Response(204);
        }
        if (in_array($request->operationId, Routes::LISTS, true)) {
            return self::json($stub === [] ? [] : array_values($stub));
        }

        return self::json($this->body($model, $request, $stub));
    }

    /**
     * @param array<string, mixed> $stub
     *
     * @return array<string, mixed>
     */
    private function body(string $model, RecordedRequest $request, array $stub): array
    {
        /** @var class-string<Model> $class */
        $class = 'VexPay\\Generated\\Models\\' . $model;
        $overlay = array_replace(
            $request->pathParams,
            array_filter($request->query, 'is_string'),
            $request->body ?? [],
            self::DEFAULTS[$request->operationId] ?? [],
        );

        return array_replace($this->sampler->sample($class, $overlay), $stub);
    }

    private function record(RequestInterface $request): ?RecordedRequest
    {
        $path = $request->getUri()->getPath();
        $best = null;
        foreach (Routes::ROUTES as $operationId => [$method, $template]) {
            if ($method !== $request->getMethod()) {
                continue;
            }
            $pattern = '#^' . preg_replace('/\\\\\{(\w+)\\\\\}/', '(?P<$1>[^/]+)', preg_quote($template, '#')) . '$#';
            if (preg_match($pattern, $path, $matches) !== 1) {
                continue;
            }
            $params = [];
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $params[$key] = rawurldecode($value);
                }
            }
            // A literal segment beats a placeholder: /v1/payouts/batch is not /v1/payouts/{id}.
            if ($best === null || count($params) < count($best[1])) {
                $best = [$operationId, $params];
            }
        }
        if ($best === null) {
            return null;
        }

        parse_str($request->getUri()->getQuery(), $query);
        $raw = (string) $request->getBody();
        $body = $raw === '' ? null : json_decode($raw, true);

        return new RecordedRequest(
            $best[0],
            $request->getMethod(),
            $path,
            $best[1],
            $query,
            is_array($body) ? $body : null,
            $request->getHeaders(),
        );
    }

    private static function json(mixed $body, int $status = 200): ResponseInterface
    {
        return new Response($status, ['Content-Type' => 'application/json'], json_encode($body, JSON_THROW_ON_ERROR));
    }
}
