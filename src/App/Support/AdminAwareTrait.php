<?php

namespace App\Support;

use DateTime;
use DateTimeInterface;

// From 'charcoal-translator'
use Charcoal\Translator\Translation;

// From 'charcoal-object'
use Charcoal\Object\PublishableInterface as Publishable;
use Charcoal\Object\RoutableInterface;

// From 'charcoal-cms'
use Charcoal\Cms\TemplateableInterface as Templateable;

/**
 * A model in the admin module.
 */
trait AdminAwareTrait
{
    /**
     * The form structure key.
     *
     * @var string|null
     */
    protected $formIdent;

    /**
     * The registered string macros.
     *
     * @var array|null
     */
    protected $macros;

    /**
     * Get the key for the form structure to use.
     *
     * @return string|null
     */
    public function formIdent()
    {
        if ($this->formIdent === null) {
            $this->formIdent = $this->resolveFormIdent($this['id'] ? 'app.edit' : 'app.create');
        }

        return $this->formIdent;
    }

    /**
     * Resolve the key for this model's form structure to use.
     *
     * @param  mixed $ident A form identifier to lookup.
     * @return string The resolved form identifier.
     */
    protected function resolveFormIdent($ident)
    {
        if ($this instanceof Templateable) {
            $template = $this['templateIdent'];
            $metadata = $this->metadata();
            if (isset($metadata['admin']['forms'][$template])) {
                $ident = $template;
            }
        }

        if ($this instanceof Publishable) {
            if ($this['publishStatus'] !== Publishable::STATUS_PUBLISHED) {
                $ident = 'app.draft';
            }
        }

        return $ident;
    }

    /**
     * Get the model's macros.
     *
     * @return mixed[]
     */
    public function macro()
    {
        if ($this->macros === null) {
            $this->macros = [];

            if (is_callable([ $this, 'macroable' ])) {
                $properties = $this->macroable();

                $date = function ($time) {
                    if ($time instanceof DateTimeInterface) {
                        return [
                            'atom'     => $time->format(DateTime::ATOM),
                            'dateTime' => $time->format(SQL_DATETIME_FORMAT),
                            'date'     => $time->format(SQL_DATE_FORMAT),
                            'time'     => $time->format(SQL_TIME_FORMAT),
                        ];
                    } else {
                        return null;
                    }
                };

                $this->macros = [];
                foreach ($properties as $key => $prop) {
                    if ($prop === null) {
                        $prop = $key;
                    }

                    if (isset($this[$prop])) {
                        $value = $this[$prop];
                        if ($value instanceof DateTimeInterface) {
                            $this->macros[$key] = $date($value);
                        }
                    }
                }
            }
        }

        return $this->macros;
    }

    /**
     * Retrieve the flattened URL Translation for usage in the admin interface.
     *
     * @return array
     */
    public function adminViewUrl()
    {
        if ($this instanceof RoutableInterface && $this['url'] instanceof Translation) {
            $url = $this['url']->data();

            return $url;
        } else {
            return [
                'en' => '',
                'fr' => '',
            ];
        }
    }
}
