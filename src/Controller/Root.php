<?php declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;
use ReactiveApps\Command\HttpServer\Annotations\Method;
use ReactiveApps\Command\HttpServer\Annotations\Route;
use RingCentral\Psr7\Response;

final class Root
{
    /**
     * @Method("GET")
     * @Route("/")
     *
     * @param  ServerRequestInterface $request
     * @return Response
     */
    public static function ping(ServerRequestInterface $request)
    {
        return new Response(
            200,
            ['Content-Type' => 'text'],
            'Come back later'
        );
    }
}
