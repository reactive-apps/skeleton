<?php declare(strict_types=1);

return [
    'app.name' => 'reactphp-silly-app-skeleton',
    'app.version' => \trim(\file_exists(ROOT . 'version') ? \file_get_contents(ROOT . 'version') : 'dev-' . \time()),
];
