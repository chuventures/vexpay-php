<?php

declare(strict_types=1);

namespace VexPay\Tests\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use VexPay\Internal\Config;
use VexPay\Internal\Requester;
use VexPay\VexPayClient;

/**
 * Scripted Guzzle transport that records every request (and its Guzzle options).
 */
final class MockApi
{
    public const BASE_URL = 'https://api.test';

    /** @var list<array{request: RequestInterface, options: array<string, mixed>}> */
    public array $history = [];

    /** @var list<float> */
    public array $sleeps = [];

    public readonly Client $guzzle;

    private readonly MockHandler $handler;

    public function __construct()
    {
        $this->handler = new MockHandler();
        $stack = HandlerStack::create($this->handler);
        $history = &$this->history;
        $stack->push(Middleware::history($history));
        $this->guzzle = new Client(['handler' => $stack, 'http_errors' => false]);
    }

    /**
     * @param array<string, string> $headers
     */
    public function reply(int $status, mixed $body = null, array $headers = []): self
    {
        $content = $body === null ? '' : json_encode($body, JSON_THROW_ON_ERROR);
        $this->handler->append(new Response($status, ['Content-Type' => 'application/json'] + $headers, $content));

        return $this;
    }

    /**
     * @param \Closure(RequestInterface): Response $handler
     */
    public function replyWith(\Closure $handler, int $times = 1): self
    {
        for ($i = 0; $i < $times; ++$i) {
            $this->handler->append(static fn (RequestInterface $request) => $handler($request));
        }

        return $this;
    }

    public function failWith(\Throwable $exception): self
    {
        $this->handler->append($exception);

        return $this;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function client(array $config = []): VexPayClient
    {
        return new VexPayClient($config + ['api_key' => 'sk_test', 'base_url' => self::BASE_URL, 'http_client' => $this->guzzle]);
    }

    /**
     * @param array<string, mixed> $config
     */
    public function requester(array $config = []): Requester
    {
        $sleeps = &$this->sleeps;

        return new Requester(
            new Config($config + ['api_key' => 'sk_test', 'base_url' => self::BASE_URL, 'http_client' => $this->guzzle]),
            static function (float $seconds) use (&$sleeps): void {
                $sleeps[] = $seconds;
            },
        );
    }

    public function request(int $index = 0): RequestInterface
    {
        return $this->history[$index]['request'];
    }

    /**
     * @return list<string> path + query of every request
     */
    public function paths(): array
    {
        return array_map(static function (array $entry): string {
            $uri = $entry['request']->getUri();

            return $uri->getPath() . ($uri->getQuery() !== '' ? '?' . $uri->getQuery() : '');
        }, $this->history);
    }

    public function count(): int
    {
        return count($this->history);
    }
}
