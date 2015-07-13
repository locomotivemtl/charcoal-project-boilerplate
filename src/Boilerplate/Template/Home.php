<?php

namespace Boilerplate\Template;

use Boilerplate\Template as Template;

class Home extends Template
{
    /**
     * @return string
     */
    public function test()
    {
        return 'TEST '.rand(0, 100);
    }
}
