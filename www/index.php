<?php
// From `charcoal-core`
use \Charcoal\Charcoal as Charcoal;

// From `charcoal-admin
use \Charcoal\Admin\AdminModule as AdminModule;

use \Boilerplate\BoilerplateModule as BoilerplateModule;

include '../vendor/autoload.php';

// Setup configuration and initialize Charcoal
Charcoal::init([
    'config'=>'../config/config.php'
]);

// Handle admin request
Charcoal::app()->group('/'.Charcoal::config('admin_path'), function()  {
    //var_dump('...');
    $admin_config = [
        'config'=>[
            'base_path'=>Charcoal::config('admin_path')
        ]
    ];
    $admin_module = new AdminModule($admin_config);
    $admin_module->setup_routes();
});

// Handle all other requests, in main namespace
$boilerplate_module = new BoilerplateModule();
$boilerplate_module->setup_routes();

Charcoal::app()->run();
