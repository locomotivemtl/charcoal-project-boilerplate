<?php

/** The application's absolute root path */
$this['base_path'] = dirname(__DIR__).'/';

/** Import core settings */
$this->addFile(__DIR__ . '/config.json');

/** Import Boilerplate middlewares */
$this->addFile(__DIR__ . '/middlewares.json');

/** Import Boilerplate routes */
$this->addFile(__DIR__ . '/routes.json');

/** Import Boilerplate redirections */
$this->addFile(__DIR__ . '/redirections.json');

$environment = getenv('APPLICATION_ENV') ?: 'local';

/** Import local settings */

$cfg = sprintf('%1$s/config.%2$s.json', __DIR__, $environment);
if (file_exists($cfg)) {
    $this->addFile($cfg);
}


