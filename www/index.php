<?php

// 3rd-party libraries dependencies. from Slim
use \Slim\Container;
use \Slim\App;
//use \Slim\Flash\Messages;

// From `charcoal-core`
use \Charcoal\CharcoalModule;
use \Charcoal\CharcoalConfig;

// From `charcoal-admin
use \Charcoal\Admin\AdminModule as AdminModule;

use \Boilerplate\BoilerplateModule as BoilerplateModule;

/** Require the Charcoal Framework */
include '../vendor/autoload.php';

// create container and configure it
$container = new Container();

$container['config'] = function($c) {
    $config = new CharcoalConfig();
    $config->add_file('../config/config.php');
    return $config;
};

/*
$container['flash'] = function ($c) {
    return new Messages;
};
*/

$app = new App($container);

CharcoalModule::setup($app);
AdminModule::setup($app);
//MessagingModule::setup($app);
BoilerplateModule::setup($app);

$app->run();


