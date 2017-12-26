<?php declare(strict_types=1);

use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;


return [
    LoopInterface::class => function () {
        return Factory::create();
    },
];

