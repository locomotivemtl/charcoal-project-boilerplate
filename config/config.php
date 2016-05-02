<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

$base_dir = realpath(__DIR__.'/..').'/';
$this['ROOT'] = $base_dir.'www/';

/**
* Import project configuration
*/
$this->addFile(__DIR__.'/config.json');
$applicationEnv = preg_replace('/!^[A-Za-z0-9_]+$/', '', getenv('APPLICATION_ENV'));
if (!$applicationEnv) {
    $applicationEnv = 'local';
}
if(file_exists(__DIR__.'/config.'.$applicationEnv.'.json')) {
    $this->addFile(__DIR__.'/config.'.$applicationEnv.'.json');
}

// Load routes
$this->addFile(__DIR__.'/routes.json');
