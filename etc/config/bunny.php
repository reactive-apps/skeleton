<?php declare(strict_types=1);

return [
    'bunny.host' => \getenv('MQ_HOST'),
    'bunny.vhost' => \getenv('MQ_VHOST'),
    'bunny.user' => \getenv('MQ_USER'),
    'bunny.password' => \getenv('MQ_PASSWORD'),
];
