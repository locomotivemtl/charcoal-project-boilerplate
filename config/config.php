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
$appEnv = preg_replace('/!^[A-Za-z0-9_]+$/', '', getenv('APPLICATION_ENV'));
if (!$appEnv) {
    $appEnv = 'local';
}
if (file_exists(__DIR__.'/config.'.$appEnv.'.json')) {
    $this->addFile(__DIR__.'/config.'.$appEnv.'.json');
}
