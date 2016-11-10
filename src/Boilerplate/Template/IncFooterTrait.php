<?php

namespace Boilerplate\Template;

/**
 *
 */
trait IncFooterTrait
{
    /**
     * @return string
     */
    public function copyright()
    {
        return sprintf('© %s %s', $this->companyName(), $this->year());
    }

    /**
     * @return string
     */
    public function companyName()
    {
        return 'Company';
    }

    /**
     * Retrieve current year (for copyright info).
     *
     * @return string
     */
    public function year()
    {
        return date('Y');
    }
}
