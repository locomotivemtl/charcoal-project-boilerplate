<?php

namespace Boilerplate;

use \Charcoal\Template\AbstractTemplate as AbstractTemplate;

class Template extends AbstractTemplate
{
    public function __construct($data=null)
    {
        //parent::__construct($data);
        $this->metadata();
    }

    public function page_title()
    {
        return 'Page title';
    }
}
