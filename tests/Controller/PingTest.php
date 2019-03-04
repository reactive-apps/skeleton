<?php declare(strict_types=1);

namespace App\Tests\Controller;

use ApiClients\Tools\TestUtilities\TestCase;
use App\Controller\Ping;
use RingCentral\Psr7\ServerRequest;

/**
 * @internal
 */
final class PingTest extends TestCase
{
    public function testPing(): void
    {
        $response = Ping::ping(new ServerRequest('GET', 'https://example.com'));
        self::assertSame(200, $response->getStatusCode());
    }
}
