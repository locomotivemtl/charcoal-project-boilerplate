<?php

namespace Boilerplate;

// From `charcoal-base`
use \Charcoal\App\Template\AbstractTemplate;

/**
 * Base class for all "Boilerplate" templates.
 */
abstract class BoilerplateTemplate extends AbstractTemplate
{
    /**
     * @return string
     */
    public function pageTitle()
    {
        return 'Page title';
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
