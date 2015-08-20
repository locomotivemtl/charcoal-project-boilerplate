<?php

namespace Boilerplate;

use \Exception as Exception;

// From PSR-7
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

// From `charcoal-core`
use \Charcoal\Charcoal as Charcoal;

// From `charcoal-base`
use \Charcoal\Action\ActionFactory as ActionFactory;
use \Charcoal\Module\AbstractModule as AbstractModule;
use \Charcoal\Template\TemplateView as TemplateView;

class BoilerplateModule
{
    /**
    * @var AdminConfig $_config
    */
    private $_config;
    /**
    * @var \Slim\App $_app
    */
    private $_app;

    static public function setup($app)
    {
        // A session is necessary for the admin module
        if (session_id() === '') {
            session_start();
        }

        $container = $app->getContainer();
        $container['boilerplate/module'] = function($c) use ($app) {
            return new BoilerplateModule([
                //'config'=>$c['charcoal/admin/config'],
                'app'=>$app
            ]);
        };

        /*$container['boilerplate/config'] = function($c) {
            $config = new BoilerplateConfig();
            $config->set_data($c['config']->get('boilerplate'));
            return $config;
        };*/

        // Admin module
        $app->get('/', 'boilerplate/module:default_route');
        $container['boilerplate/module']->setup_routes();
    }

    public function __construct($data)
    {
        //$this->_config = $data['config'];
        $this->_app = $data['app'];
    }


    /**
    * Setup web routes for the module
    *
    * Register all of the routes for the module. Tell Charcoal the URIs
    * it should respond to and give it the controller or template to call
    * when that URI is requested.
    *
    * @return BoilerplateModule Chainable
    */
    public function setup_routes()
    {

        $this->_app->get('/:actions+?', function (ServerRequestInterface $request, ResponseInterface $response, $actions=['home']) {
            var_dump($actions);
            $template = implode('/', $actions);
            $view = new TemplateView();
            $view->from_ident('boilerplate/template/'.$template);
            $content = $view->render();

            if ($content) {
                echo $content;
            } else {
                Charcoal::app()->halt(404, 'Page not found');
            }
            return $response;
        });

        return $this;
    }

    public function default_route(ServerRequestInterface $request, ResponseInterface $response, $args = null)
    {
        $view = new TemplateView();
        $content = $view->from_ident('boilerplate/template/home')->render();
        $response->write($content);
        return $response;
    }

    /**
    * Setup CLI routes for the module
    *
    * @return BoilerplateModule Chainable
    */
    public function setup_cli_routes()
    {
        $this->_app->get('/:actions+', function ($actions) {
            try {
                $action_ident = implode('/', $actions);
                $action = ActionFactory::instance()->get('boilerplate/action/cli/'.$action_ident);
                $action->run();
            } catch (Exception $e) {
                die($e->getMessage()."\n");
            }
        });

        return $this;
    }

    public function app()
    {
        return $this->_app;
    }

    /**
    * @return Config
    */
    public function config()
    {
        return $this->_config;
    }
}
