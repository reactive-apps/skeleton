<?php declare(strict_types=1);

namespace App\Tests\Controller;

use ApiClients\Tools\TestUtilities\TestCase;
use App\Controller\Root;
use React\EventLoop\Factory;
use React\Promise\Promise;
use ReactiveApps\Command\HttpServer\TemplateResponse;
use Recoil\React\ReactKernel;
use RingCentral\Psr7\ServerRequest;

/**
 * @internal
 */
final class RootTest extends TestCase
{
    public function testRoot(): void
    {
        $time = \time();
        do {
            \usleep(100);
        } while ($time === \time());

        $loop = Factory::create();
        $creationTime = \time();
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
        /** @var TemplateResponse $response */
        $response = $this->await($promise, $loop);
        $finishedTime = \time();
        self::assertSame(200, $response->getStatusCode());
        self::assertSame(
            [
                'Content-Type' => [
                    'text/plain',
                ],
            ],
            $response->getHeaders()
        );
        $took = $finishedTime - $creationTime;
        self::assertSame('', $response->getBody()->getContents());
        self::assertSame(
            [
                'uptime' => $took,
                'took' => $took,
            ],
            $response->getTemplateData()
        );
    }
}
