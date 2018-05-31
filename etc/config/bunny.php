<?php

use React\EventLoop\LoopInterface;
use React\Http\Response;
use React\Promise\Promise;
use ReactiveApps\Rx\Shutdown;
use WyriHaximus\React\ObservableBunny\Message;

return [
    'bunny.host' => 'localhost',
    'bunny.vhost' => '/',
    'bunny.user' => 'test',
    'bunny.password' => 'test',
    'bunny.queues' => function (LoopInterface $loop, Shutdown $shutdown) {
        return [
            'foo.bar' => function (Message $message) use ($loop, $shutdown) {
                $timer = null;
                /*$dispose = $shutdown->subscribe(null, null, function () use ($message, &$timer, $loop) {
                    $loop->cancelTimer($timer);
                    return $message->nack();
                });*/
                $timer = $loop->addTimer(1, function () use ($message/*, $dispose*/) {
                    //$dispose->dispose();

                    var_export([
                        $message->getMessage(),
                    ]);

                    $message->ack();
                });
            }
        ];
    },
];
