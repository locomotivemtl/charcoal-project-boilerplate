<?php

namespace App\Template;

// From App
use App\Template\AbstractTemplate;

/**
 * Template Controller: Front Page
 */
class HomeTemplate extends AbstractTemplate
{
    /**
     * @return string
     */
    public function test()
    {
        return 'TEST '.rand(0, 100);
    }
}
