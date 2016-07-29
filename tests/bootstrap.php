<?php

/**
 * Test Charcoal
 *
 * @package Charcoal
 */

/** Composer autoloader for Charcoal's PSR4-compliant Unit Tests */
$autoloader = require __DIR__.'/../vendor/autoload.php';
$autoloader->add('Charcoal\\', __DIR__.'/src/');
$autoloader->add('Charcoal\\Tests\\', __DIR__);
