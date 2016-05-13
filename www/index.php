<?php
/**
* Alertes Saint Constant Charcoal Front-Controller
*
* The basic "charcoal-app" dependencies are defined in the custom Charcoal App Container.
*
* @see \Charcoal\App\AppContainer
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

use \Charcoal\App\App;
use \Charcoal\App\AppConfig;
use \Charcoal\App\AppContainer;

// If using PHP's built-in server, return false for existing files on filesystem
if (php_sapi_name() === 'cli-server') {
    $filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (is_file($filename)) {
        return false;
    }
}

// This project requires composer.
include '../vendor/autoload.php';

$config = new AppConfig();
$config->addFile(__DIR__.'/../config/config.php');
$config->set('ROOT', dirname(__DIR__) . '/');

// Create container and configure it (with charcoal-config)
$container = new AppContainer([
    'settings' => [
        'displayErrorDetails' => true
    ],
    'config' => $config
]);

// Charcoal / Slim is the main app
$app = App::instance($container);

if (!session_id()) {
    session_start();
}

$app->run();
