<?php

/**
* Charcoal Configuration
*
* @package Charcoal\Boilerplate
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

$this['ROOT'] = realpath(__DIR__.'/../www/');

/**
* Import project configuration
*/

$this->add_file(__DIR__.'/config.json');

$application_env = $this->application_env();
if(file_exists(__DIR__.'/config.'.$application_env.'.json')) {
    $this->add_file(__DIR__.'/config.'.$application_env.'.json');
}

$this->set_template_path([
    realpath(__DIR__.'/../templates/')
]);

$this->set_metadata_path([
    realpath(__DIR__.'/../vendor/locomotivemtl/charcoal-base/metadata/'),
    realpath(__DIR__.'/../vendor/locomotivemtl/charcoal-cms/metadata/'),
    realpath(__DIR__.'/../metadata/')
]);
