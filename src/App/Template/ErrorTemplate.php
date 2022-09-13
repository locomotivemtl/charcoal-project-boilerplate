<?php

namespace App\Template;

use App\Template\AbstractTemplate;
use Charcoal\App\Handler\AbstractError;
use Charcoal\App\Handler\HandlerAwareTrait;

/**
 * Template Controller: Error Handler
 */
class ErrorTemplate extends AbstractTemplate
{
    use HandlerAwareTrait;

    /**
     * Retrieve the application debug mode.
     *
     * @return bool
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
     */
    public function errorCode(): ?int
    {
        $handler = $this->appHandler();
        if ($handler instanceof AbstractError) {
            return $handler->getCode();
        }

        return null;
    }

    /**
     * Get the error message.
     */
    public function errorMessage(): ?string
    {
        $handler = $this->appHandler();
        if ($handler instanceof AbstractError) {
            return $handler->getMessage();
        }

        return null;
    }

    /**
     * Get the error title.
     */
    public function errorTitle(): ?string
    {
        $handler = $this->appHandler();
        if ($handler instanceof AbstractError) {
            return $handler->getSummary();
        }

        return null;
    }

    /**
     * Get the error details as HTML.
     */
    public function htmlErrorDetails(): ?string
    {
        if ($this->debug()) {
            $handler = $this->appHandler();
            if ($handler instanceof AbstractError) {
                return $handler->renderHtmlErrorDetails();
            }
        }

        return null;
    }
}
