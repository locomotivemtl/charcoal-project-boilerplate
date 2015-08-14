<?php

namespace Boilerplate\Template;

use Boilerplate\BoilerplateTemplate;

class HomeTemplate extends BoilerplateTemplate
{
    /**
    * @return string
    */
    public function test()
    {
        return 'TEST '.rand(0, 100);
    }
}
