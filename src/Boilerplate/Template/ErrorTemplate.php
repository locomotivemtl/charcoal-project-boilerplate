<?php

namespace Boilerplate\Template;

use Boilerplate\Template\AbstractBoilerplateTemplate;

/**
 * Boilerplate Error Handler Template Controller
 */
class ErrorTemplate extends AbstractBoilerplateTemplate
{
    /**
     * The current error title.
     *
     * @var Translation|string|null
     */
    private $errorTitle;

    /**
     * The current error message.
     *
     * @var Translation|string|null
     */
    private $errorMessage;

    /**
     * @return string|TranslationString
     */
    public function pageTitle()
    {
        return $this->errorTitle();
    }

    /**
     * Retrieve the error message.
     *
     * @return Translation|string|null
     */
    public function errorMessage()
    {
        if ($this->debug()) {
            return $this->errorTitle;
        } else {
            return $this->translator()->translation('The page you are looking for could not be found.');
        }
    }

    /**
     * Set the handler's error message.
     *
     * @param  string $message A message.
     * @return self
     */
    public function setErrorMessage($message)
    {
        $this->errorMessage = $this->translator()->translation($message);

        return $this;
    }

    /**
     * Retrieve the error title.
     *
     * @return Translation|string|null
     */
    public function errorTitle()
    {
        if ($this->debug()) {
            return $this->errorTitle;
        } else {
            return $this->translator()->translation('Page Not Found');
        }
    }

    /**
     * Set the handler's error title.
     *
     * @param  string $title A title.
     * @return self
     */
    public function setErrorTitle($title)
    {
        $this->errorTitle = $this->translator()->translation($title);

        return $this;
    }
}
