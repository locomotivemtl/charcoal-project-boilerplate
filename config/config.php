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
ini_set('display_errors', true);

/** The application's absolute root path */
$this['base_path'] = dirname(__DIR__).'/';

/** Import core settings */
$this->addFile(__DIR__ . '/config.json');

/** Import Boilerplate routes */
$this->addFile(__DIR__ . '/routes.json');

/**
 * Load environment settings; such as database credentials
 * or credentials for 3rd party services.
 */
$app_environment = getenv('APPLICATION_ENV');
if ( ! $app_environment ) {
    $app_environment = 'local';
}

if ( isset($app_environment) && $app_environment ) {
    $environment = preg_replace('/[^A-Za-z0-9_]+/', '', $app_environment);

    /** Import local settings */
    $exts = [ 'php', 'json', 'yml', 'yaml', 'ini' ];
    while ( $exts ) {
        $ext = array_pop($exts);
        $cfg = sprintf('%1$s/config.%2$s.%3$s', __DIR__, $environment, $ext);

        if ( file_exists($cfg) ) {
            $this->addFile($cfg);
            break;
        }
    }
}
