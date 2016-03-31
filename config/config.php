<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

$base_dir = realpath(__DIR__.'/..').'/';
$this['ROOT'] = $base_dir.'www/';

/**
* Import project configuration
*/
$this->addFile(__DIR__.'/config.json');
$application_env = preg_replace('/!^[A-Za-z0-9_]+$/', '', getenv('APPLICATION_ENV'));if(file_exists(__DIR__.'/config.'.$application_env.'.json')) {
    $this->addFile(__DIR__.'/config.'.$application_env.'.json');
}

// Load routes
$this->addFile(__DIR__.'/routes.json');

$this['metadata_path'] = [
    $base_dir.'vendor/locomotivemtl/charcoal-admin/metadata/',
    $base_dir.'vendor/locomotivemtl/charcoal-app/metadata/',
    $base_dir.'vendor/locomotivemtl/charcoal-property/metadata/',
    $base_dir.'vendor/locomotivemtl/charcoal-base/metadata/',
    $base_dir.'metadata/'
];
