<?php declare(strict_types=1);

use ApiClients\Client\Supervisord\AsyncClient;
use ApiClients\Client\Supervisord\AsyncClientInterface;
use React\EventLoop\LoopInterface;

return [
    AsyncClientInterface::class => function (LoopInterface $loop) {
        return AsyncClient::create(getenv('SUPERVISOR_HOST'), $loop);
    },
];
