<?php

namespace Boilerplate;

// From `charcoal-base`
use \Charcoal\Template\AbstractTemplate as AbstractTemplate;

abstract class BoilerplateTemplate extends AbstractTemplate
{
    /**
    * @param array $data Optional
    */
    public function __construct(array $data = null)
    {
        // parent::__construct($data);
        $this->metadata();

        if (is_array($data)) {
            $this->set_data($data);
        }
    }

    /**
    * @return string
    */
    public function page_title()
    {
        return 'Page title';
    }

    /**
    * @return string
    */
    public function page_header()
    {
        return '';
    }

    /**
    * @return string
    */
    public function page_footer()
    {
        return '';
    }

    /**
    * @return string[]
    */
    public function page_styles()
    {
        return [];
    }

    /**
    * @return string[]
    */
    public function page_scripts()
    {
        return [];
    }
}
