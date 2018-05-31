<?php

use React\EventLoop\LoopInterface;
use React\Http\Response;
use React\Promise\Promise;

return [
    'http-server.address' => '0.0.0.0:8888',
    'http-server.handler' => function (LoopInterface $loop) {
        return function () use ($loop) {
            return new Promise(function ($resolve) use ($loop) {
                $loop->addTimer(10, function () use ($resolve) {
                    $resolve(new Response(200, [], 'Hello World'));
                });
            });
        };
    },
    'http-server.public' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR,
];
