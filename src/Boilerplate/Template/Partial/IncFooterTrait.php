<?php

namespace Boilerplate\Template\Partial;

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
        return sprintf('© %s %s', $this->copyrightName(), $this->copyrightYear());
    }

    /**
     * @return string
     */
    public function copyrightName()
    {
        return 'Boilerplate';
    }

    /**
     * Retrieve current year (for copyright info).
     *
     * @return string
     */
    public function copyrightYear()
    {
        return date('Y');
    }
}
