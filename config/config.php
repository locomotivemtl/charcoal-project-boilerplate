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

/** Import Boilerplate templates */

$this->addFile(__DIR__ . '/templates.json');

/** Import Boilerplate attachments */
$this->addFile(__DIR__ . '/attachments.json');

/** Import local settings */
$appEnv = 'local';
if (file_exists(__DIR__.'/config.'.$appEnv.'.json')) {
    $this->addFile(__DIR__.'/config.'.$appEnv.'.json');
}
