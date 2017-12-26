<?php declare(strict_types=1);

use DI\ContainerBuilder;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

return (function () {
    $definitions = [];
    $version = trim(file_exists(ROOT . 'version') ? file_get_contents(ROOT . 'version') : 'dev');
    $container = new ContainerBuilder();
    $definitions['app.version'] = $version;
    $definitions[OutputInterface::class] = new ConsoleOutput();

    $directory = new RecursiveDirectoryIterator(CONTAINER);
    $directory = new RecursiveIteratorIterator($directory);
    foreach ($directory as $fileinfo) {
        if (!$fileinfo->isFile()) {
            continue;
        }

        foreach (require CONTAINER . $fileinfo->getFilename() as $key => $factory) {
            $definitions[$key] = $factory;
        }
    }

    $container->addDefinitions($definitions);

    return $container->build();
})();
