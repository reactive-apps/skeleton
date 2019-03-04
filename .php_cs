<?php declare(strict_types=1);

use ApiClients\Tools\TestUtilities\PhpCsFixerConfig;

return (function ()
{
    $paths = [
        __DIR__ . DIRECTORY_SEPARATOR . 'etc',
        __DIR__ . DIRECTORY_SEPARATOR . 'src',
        __DIR__ . DIRECTORY_SEPARATOR . 'tests',
    ];

    return PhpCsFixerConfig::create()
        ->setFinder(
            PhpCsFixer\Finder::create()
                ->in($paths)
        )
        ->setUsingCache(false)
    ;
})();
