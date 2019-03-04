#!/usr/bin/php
<?php declare(strict_types=1);

use Dotenv\Dotenv;
use ReactiveApps\App;
use ReactiveApps\ContainerFactory;

const ROOT = __DIR__ . DIRECTORY_SEPARATOR;

/**
 * Require Composer's autoloader
 */
require ROOT . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Load configuration
 */
Dotenv::create(__DIR__)->load();

/**
 * Create and boot up the application
 */
exit((function (array $argv) {
    return ContainerFactory::create()->get(App::class)->boot($argv);
})($argv));
