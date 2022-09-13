<?php

namespace App\Template;

use App\Template\AbstractTemplate;

/**
 * Template Controller: Front Page
 */
class HomeTemplate extends AbstractTemplate
{
    /**
     * @return string
     */
    public function getTest(): string
    {
        return 'TEST ' . rand(0, 100);
    }
}
