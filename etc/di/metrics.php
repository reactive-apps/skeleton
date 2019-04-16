<?php declare(strict_types=1);

use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Exception\ClientException;
use function DI\factory;
use Psr\Log\LoggerInterface;
use ReactiveApps\Command\Metrics\HandlerInterface;
use ReactiveApps\Rx\Shutdown;
use Recoil\Kernel;
use Rx\Subject\Subject;
use WyriHaximus\PSR3\ContextLogger\ContextLogger;
use WyriHaximus\React\Inspector\Metric;

return [
    HandlerInterface::class => factory(function (
        Kernel $kernel,
        Client $bunny,
        LoggerInterface $logger
    ) {
        return new class($kernel, $bunny, $logger) implements HandlerInterface {
            /** @var Subject */
            private $stream;

            /** @var Client */
            private $bunny;

            public function __construct(
                Kernel $kernel,
                Client $bunny,
                LoggerInterface $logger
            ) {
                $this->bunny = $bunny;

                $logger = new ContextLogger($logger, ['section' => 'metrics handler'], 'metrics handler');
                $this->stream = new Subject();

                $kernel->execute(function () use ($bunny, $logger) {
                    yield;
                    $logger->debug('Connecting');
                    try {
                        $bunny = yield $bunny->connect();
                    } catch (ClientException $ce) {
                        // Already connected
                    }
                    $logger->debug('Connected');

                    $logger->debug('Opening channel');
                    /** @var Channel $channel */
                    $channel = yield $bunny->channel();
                    $logger->debug('Opened channel');

                    $this->stream->subscribe(function (Metric $metric) use ($channel): void {
                        $channel->publish('PREFIX.TYPE.APP_NAME.' . $metric->getKey() . ' ' . $metric->getValue() . ' ' . $metric->getTime(), [], '', 'graphite');
                    });
                });
            }

            public function handle(Metric $metric): void
            {
                $this->stream->onNext($metric);
            }

            public function shutdown(): void
            {
                $this->stream->onCompleted();
                $this->bunny->disconnect();
            }
        };
    }),
];
