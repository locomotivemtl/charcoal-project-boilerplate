#!/usr/bin/env php
<?php
use \Exception as Exception;
use \Slim\Environment as SlimEnvironment;

// From `charcoal-core`
use \Charcoal\Charcoal as Charcoal;
// From `charcoal-base`
use \Charcoal\Action\ActionFactory as ActionFactory;
// From `charcoal-admin
use \Charcoal\Admin\Module as AdminModule;

include 'vendor/autoload.php';

// Ensure CLI mode
if(php_sapi_name() !== 'cli') {
    die('This program can only be executed from a terminal (CLI / Command Line Interface'."\n");
}

// Convert command line arguments into a URL (for Slim)
$argv = $GLOBALS['argv'];
if(!isset($argv[1])) {
    die('This script requires at least one parameter: the action name / ident.'."\n");
}

// Setup configuration and initialize Charcoal
Charcoal::init([
    'config'=>'config/config.php'
]);

$path = '/'.$argv[1];
// Set up the environment so that Slim can route
Charcoal::app()->environment = SlimEnvironment::mock([
    'PATH_INFO' => $path
]);

// CLI-compatible not found error handler
Charcoal::app()->notFound(function () {
    $url = Charcoal::app()->environment['PATH_INFO'];
    echo "Error: Cannot route to $url";
    Charcoal::app()->stop();
});

// Format errors for CLI
Charcoal::app()->error(function (Exception $e) {
    echo $e;
    Charcoal::app()->stop();
});

// Handle admin CLI action
Charcoal::app()->group('/'.Charcoal::config('admin_path'), function()  {
    //var_dump('...');
    $admin_module = new AdminModule([
        'config' => [
            'base_path' => Charcoal::config('admin_path')
        ]
    ]);
    $admin_module->setup_cli_routes();
});

Charcoal::app()->get('/:actions+', function ($actions) {
    try {
        $action_ident = implode('/', $actions);
        $action = ActionFactory::instance()->get('boilerplate/action/cli/'.$action_ident);
        $action->run();
    }
    catch(Exception $e) {
        die($e->getMessage()."\n");
    }
});

Charcoal::app()->run();
