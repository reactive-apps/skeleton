<?php declare(strict_types=1);

return [
    'supervisor.process.host' => \getenv('SUPERVISOR_HOST'),
    'supervisor.process.name' => \getenv('SUPERVISOR_NAME'),
];
