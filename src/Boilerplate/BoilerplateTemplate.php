<?php

namespace Boilerplate;

// Dependencies from `pimple`
use \Pimple\Container;

// From `charcoal-base`
use \Charcoal\App\Template\AbstractTemplate;

/**
 * Base class for all "Boilerplate" templates.
 */
abstract class BoilerplateTemplate extends AbstractTemplate
{

    /**
     * @param Container $container The pimple DI container.
     */
    public function setDependencies(Container $container)
    {
        // Set required service dependencies here.
        // ex: $this->setModelFactory($container['model/factory']);
    }

    /**
     * @return string
     */
    public function pageTitle()
    {
        return 'Charcoal Project Boilerplate';
    }

    /**
     * @return string
     */
    public function pageHeader()
    {
        return '';
    }

    /**
     * @return string
     */
    public function pageFooter()
    {
        return '';
    }

    /**
     * @return string[]
     */
    public function pageStyles()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function pageScripts()
    {
        return [];
    }
}
