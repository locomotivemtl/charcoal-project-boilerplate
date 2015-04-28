<?php

use \Charcoal\Charcoal as Charcoal;

// Composer autoloader for Charcoal's psr4-compliant Unit Tests
$autoloader = require __DIR__ . '/../vendor/autoload.php';
$autoloader->add('Charcoal\\', __DIR__.'/src/');
$autoloader->add('Charcoal\\Tests\\', __DIR__);


// This var needs to be set automatically, for now
Charcoal::init();
Charcoal::config()['ROOT'] = '';

