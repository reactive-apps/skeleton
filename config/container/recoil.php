<?php declare(strict_types=1);

use Monolog\ErrorHandler;
use React\EventLoop\LoopInterface;
use Recoil\Kernel;
use Recoil\React\ReactKernel;

return [
    Kernel::class => function (LoopInterface $loop, ErrorHandler $errorHandler) {
        $kernel = ReactKernel::create($loop);
        $kernel->setExceptionHandler([$errorHandler, 'handleException']);
        return $kernel;
    },
];
