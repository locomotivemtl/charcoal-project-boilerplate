<?php

/**
* Charcoal
*
* @package Charcoal\Boilerplate
*/

use \Boilerplate\BoilerplateModule as BoilerplateModule;

// From `charcoal-core`
use \Charcoal\Charcoal as Charcoal;

// From `charcoal-admin
use \Charcoal\Admin\AdminModule as AdminModule;

/** Require the Charcoal Framework */
include '../vendor/autoload.php';

/** Setup and initialize Charcoal */
Charcoal::init([
    'config'=>'../config/config.php'
]);

/** Setup, instantiate, and define the routes for the Admin module */
Charcoal::app()->group('/'.Charcoal::config('admin_path'), function()  {
    //var_dump('...');
    $admin_config = [
        'config' => [
            'base_path' => Charcoal::config('admin_path')
        ]
    ];
    $admin_module = new AdminModule($admin_config);
    $admin_module->setup_routes();
});

/** Instantiate and define the routes for the main module */
$boilerplate_module = new BoilerplateModule();
$boilerplate_module->setup_routes();

/** Run the Charcoal application */
Charcoal::app()->run();
