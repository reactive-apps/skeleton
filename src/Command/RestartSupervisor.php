<?php declare(strict_types=1);

namespace App\Command;

use ApiClients\Client\Supervisord\AsyncClientInterface;
use ApiClients\Client\Supervisord\Resource\Async\Program;
use ApiClients\Client\Supervisord\Resource\ProgramInterface;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;
use Recoil\Kernel\SystemKernel;
use Rx\React\Promise;

final class RestartSupervisor implements Command
{
    const COMMAND = 'restart-supervisor';

    /**
     * @var SystemKernel
     */
    private $kernel;

    /**
     * @var AsyncClientInterface
     */
    private $supervisor;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param SystemKernel $kernel
     * @param AsyncClientInterface $supervisor
     * @param LoggerInterface $logger
     */
    public function __construct(SystemKernel $kernel, AsyncClientInterface $supervisor, LoggerInterface $logger)
    {
        $this->kernel = $kernel;
        $this->supervisor = $supervisor;
        $this->logger = $logger;
    }

    public function __invoke()
    {
        $this->kernel->execute(function () {
            /** @var Program $program */
            $program = yield Promise::fromObservable(
                $this->supervisor->programs()->filter(function (ProgramInterface $program) {
                    return $program->name() === getenv('SUPERVISOR_NAME');
                })->take(1)
            );

            $uptime = $program->now() - $program->start();
            $this->logger->info('"' . $program->name() . '" has been up and running for ' . $uptime . ' seconds, restarting');
            $program = yield $program->restart();

            $uptime = $program->now() - $program->start();
            $this->logger->info('Restarted "' . $program->name() . '" up and running for ' . $uptime . ' seconds');
        });
    }
}
