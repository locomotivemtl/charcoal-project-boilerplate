<?php

use Charcoal\App\App;
use Charcoal\App\AppConfig;
use Charcoal\App\AppContainer;

/* If using PHP's built-in server, return false to skip existing files on the filesystem. */
if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (is_file($file)) {
        return false;
    }
}

require dirname(__DIR__) . '/vendor/autoload.php';

/* Import the application's settings */
$appConfig = new AppConfig();
$appConfig->addFile(dirname(__DIR__) . '/config/config.php');

/* Build the DI container */
$container = new AppContainer([
    'config' => $appConfig,
    'settings' => [
        'displayErrorDetails' => $appConfig['dev_mode'],
    ],
]);

/* Instantiate a Charcoal~Slim application and run */
$app = App::instance($container);
$app->run();
