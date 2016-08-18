<?php

/**
 * Charcoal - A PHP Framework
 *
 * @package   Charcoal
 * @author    Locomotive <info@locomotive.ca>
 * @copyright Copyright (c) 2016 Locomotive Inc.
 * @link      https://github.com/locomotivemtl/charcoal-project-boilerplate
 */

/** Built on top of Slim */
use \Charcoal\App\App;
use \Charcoal\App\AppConfig;
use \Charcoal\App\AppContainer;

/** If we're not using PHP 5.6+, explicitly set the default character set. */
if ( PHP_VERSION_ID < 50600 ) {
    ini_set('default_charset', 'UTF-8');
}

/**
 * If you are using PHP's built-in server, return FALSE
 * for existing files on the filesystem.
 */
if ( PHP_SAPI === 'cli-server' ) {
    $file = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);

    if ( is_file($file) ) {
        return false;
    }
}

/** Register the Composer autoloader */
require dirname(__DIR__) . '/vendor/autoload.php';

/** Start new or resume existing session */
if ( ! session_id() ) {
    session_start();
}

/** Import the application's settings */
$appConfig = new AppConfig();
$appConfig->addFile(dirname(__DIR__) . '/config/config.php');

/** Build the DI container */
$container = new AppContainer( [
    'config'   => $appConfig,
    'settings' => [
        'displayErrorDetails' => true
    ]
] );

/** Instantiate a Charcoal~Slim application */
$app = App::instance($container);

/**
 * Run The Application
 */
$app->run();
