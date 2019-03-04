<?php declare(strict_types=1);

namespace App\Command;

use ApiClients\Client\Supervisord\AsyncClientInterface;
use ApiClients\Client\Supervisord\Resource\Async\Program;
use ApiClients\Client\Supervisord\Resource\ProgramInterface;
use Cake\Chronos\Chronos;
use Psr\Log\LoggerInterface;
use Recoil\Kernel;
use Rx\React\Promise;

final class RestartSupervisor implements Command
{
    const COMMAND = 'restart-supervisor';

    /**
     * @var Kernel
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
     * @param Kernel               $kernel
     * @param AsyncClientInterface $supervisor
     * @param LoggerInterface      $logger
     */
    public function __construct(Kernel $kernel, AsyncClientInterface $supervisor, LoggerInterface $logger)
    {
        $this->kernel = $kernel;
        $this->supervisor = $supervisor;
        $this->logger = $logger;
    }

    public function __invoke(): void
    {
        $this->kernel->execute(function () {
            /** @var Program $program */
            $program = yield Promise::fromObservable(
                $this->supervisor->programs()->filter(function (ProgramInterface $program) {
                    return $program->name() === \getenv('SUPERVISOR_NAME');
                })->take(1)
            );

            $this->logger->info('"' . $program->name() . '" has been up and running for ' . $this->uptime($program) . ', restarting');
            $program = yield $program->restart();

            $this->logger->info('Restarted "' . $program->name() . '" up and running for ' . $this->uptime($program));
        });
    }

    private function uptime(ProgramInterface $program): string
    {
        $seconds = $program->now() - $program->start();

        return Chronos::create()->subSeconds($seconds)->diffForHumans(null, true);
    }
}
