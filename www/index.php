<?php
use \Charcoal\Charcoal as Charcoal;

include '../vendor/autoload.php';

// Setup configuration and initialize Charcoal
Charcoal::init([
	'config'=>'../config/config.php'
]);

// Handle request
Charcoal::app()->get('/:actions?+', function ($actions='home') {
    $view = new \Charcoal\Model\View();
	$content = $view->from_ident('boilerplate/'.$actions)->render();
	if($content) {
		echo $content;
	}
	else {
		Charcoal::app()->halt(404);
	}
});

Charcoal::app()->run();
