<?php

namespace Boilerplate;

// From `charcoal-base`
use \Charcoal\Template\AbstractTemplate as AbstractTemplate;

class Template extends AbstractTemplate
{
    public function __construct($data = null)
    {
        //parent::__construct($data);
        $this->metadata();
        if (is_array($data)) {
            $this->set_data($data);
        }
    }

    public function page_title()
    {
        return 'Page title';
    }

    public function page_header()
    {
        return '';
    }

    public function page_footer()
    {
        return '';
    }

    public function page_styles()
    {
        return [];
    }

    public function page_scripts()
    {
        return [];
    }
}
