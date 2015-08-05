<?php

/**
* Charcoal Configuration
*
* @package Charcoal\Boilerplate
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

use Charcoal\Charcoal as Charcoal;

Charcoal::config()['ROOT'] = realpath(__DIR__.'/../www/');

/**
* Import project configuration
*/

Charcoal::config()->add_file(__DIR__.'/config.json');

$application_env = Charcoal::config()->application_env();

if(file_exists(__DIR__.'/config.'.$application_env.'.json')) {
    Charcoal::config()->add_file(__DIR__.'/config.'.$application_env.'.json');
}

/**
* Define paths for templates and metadata
*/

Charcoal::config()->set_template_path([
    realpath(__DIR__.'/../templates/')
]);

Charcoal::config()->set_metadata_path([
    realpath(__DIR__.'/../vendor/locomotivemtl/charcoal-base/metadata/'),
    realpath(__DIR__.'/../vendor/locomotivemtl/charcoal-cms/metadata/'),
    realpath(__DIR__.'/../metadata/')
]);
