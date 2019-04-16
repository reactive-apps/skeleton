<?php declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;
use ReactiveApps\Command\HttpServer\Annotations\Method;
use ReactiveApps\Command\HttpServer\Annotations\Routes;
use RingCentral\Psr7\Response;

final class Ping
{
    /**
     * @Method("GET")
     * @Routes("/ping")
     *
     * @param  ServerRequestInterface $request
     * @return Response
     */
    public static function ping(ServerRequestInterface $request)
    {
        return new Response(
            200,
            ['Content-Type' => 'text'],
            'pong'
        );
    }
}
