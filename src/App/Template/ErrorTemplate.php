<?php

namespace App\Template;

// From 'charcoal-app'
use Charcoal\App\Handler\AbstractError;
use Charcoal\App\Handler\HandlerAwareTrait;

// From App
use App\Template\AbstractTemplate;

/**
 * Template Controller: Error Handler
 */
class ErrorTemplate extends AbstractTemplate
{
    use HandlerAwareTrait;

    /**
     * Retrieve the application debug mode.
     *
     * @return boolean
     */
    public function debug()
    {
        if ($this->appHandler() instanceof AbstractError) {
            return parent::debug();
        }

        return false;
    }

    /**
     * Get the error code.
     *
     * @return integer
     */
    public function errorCode()
    {
        return $this->appHandler()->getCode();
    }

    /**
     * Get the error message.
     *
     * @return string
     */
    public function errorMessage()
    {
        return $this->appHandler()->getMessage();
    }

    /**
     * Get the error title.
     *
     * @return string
     */
    public function errorTitle()
    {
        return $this->appHandler()->getSummary();
    }

    /**
     * Get the error details as HTML.
     *
     * @return string|null
     */
    final public function htmlErrorDetails()
    {
        if ($this->debug()) {
            return $this->appHandler()->renderHtmlErrorDetails();
        } else {
            return null;
        }
    }
}
