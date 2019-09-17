<?php

namespace Boilerplate\Template;

// From 'boilerplate'
use Boilerplate\Template\AbstractBoilerplateTemplate;

/**
 * Boilerplate Home Template Controller.
 */
class HomeTemplate extends AbstractBoilerplateTemplate
{
    /**
     * @return string
     */
    public function test()
    {
        return 'TEST '.rand(0, 100);
    }
}
