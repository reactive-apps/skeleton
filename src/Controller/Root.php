<?php declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\LoopInterface;
use ReactiveApps\Command\HttpServer\Annotations\Method;
use ReactiveApps\Command\HttpServer\Annotations\Routes;
use ReactiveApps\Command\HttpServer\Annotations\Template;
use ReactiveApps\Command\HttpServer\TemplateResponse;
use WyriHaximus\Annotations\Coroutine;
use function WyriHaximus\React\timedPromise;

/**
 * @Coroutine())
 */
final class Root
{
    /** @var LoopInterface */
    private $loop;

    /** @var int */
    private $time;

    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
        $this->time = \time();
    }

    /**
     * @Method("GET")
     * @Routes("/")
     * @Template("root")
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function root(ServerRequestInterface $request)
    {
        $start = \time();

        yield timedPromise($this->loop, \random_int(1, 5));

        return (new TemplateResponse(
            200,
            ['Content-Type' => 'text/plain']
        ))->withTemplateData([
            'uptime' => (\time() - $this->time),
            'took' => (\time() - $start),
        ]);
    }
}
