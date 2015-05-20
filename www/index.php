<?php
// From `charcoal-core`
use \Charcoal\Charcoal as Charcoal;
// From `charcoal-base`
use \Charcoal\Template\TemplateView as TemplateView;
// From `charcoal-admin
use \Charcoal\Admin\Module as AdminModule;

include '../vendor/autoload.php';

// Setup configuration and initialize Charcoal
Charcoal::init([
    'config'=>'../config/config.php'
]);

// Handle admin request
Charcoal::app()->group('/'.Charcoal::config('admin_path'), function()  {
    //var_dump('...');
    $admin_module = new AdminModule([
        'config'=>[
            'base_path'=>Charcoal::config('admin_path')
        ]
    ]);
    $admin_module->setup_routes();
});

// Default template, by default
Charcoal::app()->get('/:actions+?', function ($actions=['home']) {
    $template = implode('/', $actions);
    $view = new TemplateView();
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
