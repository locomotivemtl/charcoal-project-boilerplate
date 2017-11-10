<?php
/**
 * Load Application Configuration
 *
 * Bootstrap the given application.
 *
 * @package Charcoal
 */

/** For the time being, let's track and show all issues. */
error_reporting(E_ALL);

/** The application's absolute root path */
$this['base_path'] = dirname(__DIR__).'/';

/** Import core settings */
$this->addFile(__DIR__ . '/config.json');

/** Admin settings */
$this->addFile(__DIR__ . '/admin.json');

/** Import Boilerplate middlewares */
$this->addFile(__DIR__ . '/middlewares.json');

/** Import Boilerplate routes */
$this->addFile(__DIR__ . '/routes.json');

/** Import Boilerplate redirections */
$this->addFile(__DIR__ . '/redirections.json');


/**
 * Load environment settings; such as database credentials
 * or credentials for 3rd party services.
 */
$app_environment = getenv('APPLICATION_ENV') ?: 'local';

if ($app_environment) {
    $environment = preg_replace('/[^A-Za-z0-9_]+/', '', $app_environment);

    /** Import local settings */
    $cfg = sprintf('%1$s/config.%2$s.json', __DIR__, $environment);
    if (file_exists($cfg)) {
        $this->addFile($cfg);
    }
}

ini_set('display_errors', $this['debug']);
