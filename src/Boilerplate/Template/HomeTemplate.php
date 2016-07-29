<?php

namespace Boilerplate\Template;

use Boilerplate\AbstractBoilerplateTemplate;

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
