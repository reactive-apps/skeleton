<?php declare(strict_types=1);

use function DI\factory;
use function DI\get;
use React\Cache\ArrayCache;
use WyriHaximus\React\Http\Middleware\MeasureMiddleware;
use WyriHaximus\React\Http\Middleware\WithHeadersMiddleware;
use WyriHaximus\React\Inspector\Http\Middleware\MeasureMiddlewareCollector;

return [
    'http-server.middleware.measure' => function (MeasureMiddlewareCollector $mmc) {
        $mm = new MeasureMiddleware();
        $mmc->register('http-server.reqs', $mm);

        return $mm;
    },
    'http-server.address' => \getenv('REACT_HTTP_SOCKET_ADDRESS'),
    'http-server.public' => \dirname(__DIR__, 2) . \DIRECTORY_SEPARATOR . 'public' . \DIRECTORY_SEPARATOR,
    'http-server.hsts' => !(\getenv('DEBUG') === 'false' ? false : true),
    'http-server.middleware.prefix' => factory(function (MeasureMiddleware $measure) {
        $middleware = [];

        $middleware[] = $measure;

        return $middleware;
    })->parameter('measure', get('config.http-server.middleware.measure')),
    'http-server.middleware.suffix' => factory(function (string $version) {
        $middleware = [];

        $middleware[] = new WithHeadersMiddleware([
            'X-Powered-By' => 'PHP/9.13.37',
        ]);

        return $middleware;
    })->parameter('version', get('config.app.version')),
    'http-server.pool.ttl' => 3.0,
    'http-server.pool.min' => 0,
    'http-server.pool.max' => 6,
    'http-server.rewrites' => [],
    'http-server.public.preload.cache' => new ArrayCache(),
];
