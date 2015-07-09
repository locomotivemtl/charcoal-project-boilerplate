<?php

namespace Boilerplate;

// From `charcoal-core`
use \Charcoal\Charcoal as Charcoal;

// From `charcoal-base`
use \Charcoal\Action\ActionFactory as ActionFactory;
use \Charcoal\Module\AbstractModule as AbstractModule;
use \Charcoal\Template\TemplateView as TemplateView;

class BoilerplateModule extends AbstractModule
{
    /**
     * Initialize the module
     *
     * @param array $data Optional
     * @return BoilerplateModule Chainable
     */
    public function init($data = null)
    {
        return $this;
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
        Charcoal::app()->get('/:actions+?', function ($actions = ['home']) {
            $template = implode('/', $actions);
            $view = new TemplateView();
            $view->from_ident('boilerplate/template/'.$template);
            $content = $view->render();

            if ($content) {
                echo $content;
            } else {
                Charcoal::app()->halt(404, 'Page not found');
            }
        });

        return $this;
    }

    /**
     * Setup CLI routes for the module
     *
     * @return BoilerplateModule Chainable
     */
    public function setup_cli_routes()
    {
        Charcoal::app()->get('/:actions+', function ($actions) {
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
}
