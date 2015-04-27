<?php
use \Charcoal\Charcoal as Charcoal;
use \Charcoal\Admin\Module as AdminModule;
use \Charcoal\Template\TemplateView as TemplateView;

include '../vendor/autoload.php';

// Setup configuration and initialize Charcoal
Charcoal::init([
	'config'=>'../config/config.php'
]);

$admin_path = 'admin';

// Handle admin request
Charcoal::app()->group('/admin', function()  {
	AdminModule::init([
		'config'=>[
			'base_path'=>'admin'
		]
	]);
});

// Default template, by default
Charcoal::app()->get('/:actions+?', function ($actions=['home']) {
	$template = implode('/', $actions);
    $view = new TemplateView;
    $view->from_ident('boilerplate/template/'.$template);
	$content = $view->render();

	if($content) {
		echo $content;
	}
	else {
		Charcoal::app()->halt(404, 'Page not found');
	}
});

Charcoal::app()->run();
