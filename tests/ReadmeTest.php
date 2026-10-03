<?php

declare(strict_types=1);

namespace VexPay\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VexPay\Testing\FakeHttpClient;
use VexPay\VexPayClient;

/**
 * Runs every ```php block in README.md against the fake transport, so examples stay in sync
 * with the SDK surface.
 */
final class ReadmeTest extends TestCase
{
    public static ?FakeHttpClient $http = null;

    /**
     * @return iterable<string, array{0: string}>
     */
    public static function examples(): iterable
    {
        $readme = (string) file_get_contents(dirname(__DIR__) . '/README.md');
        preg_match_all('/```php\n(.*?)```/s', $readme, $matches);
        foreach ($matches[1] as $index => $code) {
            yield 'example ' . ($index + 1) => [$code];
        }
    }

    public static function client(mixed $config = null): VexPayClient
    {
        if (is_array($config) && isset($config['http_client'])) {
            return new VexPayClient($config);
        }

        return new VexPayClient(['api_key' => 'test', 'http_client' => self::$http]);
    }

    #[DataProvider('examples')]
    public function testExampleRuns(string $code): void
    {
        self::$http = new FakeHttpClient();
        $code = str_replace('new VexPayClient(', '\\' . self::class . '::client(', $code);

        ob_start();
        try {
            eval($code);
        } finally {
            $output = (string) ob_get_clean();
        }

        self::assertGreaterThan(0, count(self::$http->recorded()) + strlen($output), 'example did nothing');
    }
}
