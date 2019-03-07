<?php declare(strict_types=1);

namespace App\Tests\Controller;

use ApiClients\Tools\TestUtilities\TestCase;
use App\Controller\Root;
use React\EventLoop\Factory;
use React\Promise\Promise;
use Recoil\React\ReactKernel;
use RingCentral\Psr7\ServerRequest;

/**
 * @internal
 */
final class RootTest extends TestCase
{
    public function testRoot(): void
    {
        $loop = Factory::create();
        $root = new Root($loop);
        $promise = new Promise(function ($resolve, $reject) use ($root, $loop): void {
            ReactKernel::create($loop)->execute(function () use ($resolve, $reject, $root) {
                try {
                    $resolve(yield $root->root(new ServerRequest('GET', 'https://example.com')));
                } catch (\Throwable $throwable) {
                    $reject($throwable);
                }
            });
        });
        $response = $this->await($promise, $loop);
        self::assertSame(200, $response->getStatusCode());
    }
}
