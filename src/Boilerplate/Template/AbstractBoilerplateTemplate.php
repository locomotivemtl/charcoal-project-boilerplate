<?php

namespace Boilerplate\Template;

use ArrayAccess;
use RuntimeException;
use InvalidArgumentException;

// From Pimple
use Pimple\Container;

// From PSR-7
use Psr\Http\Message\UriInterface;

// From 'charcoal-translator'
use Charcoal\Translator\TranslatorAwareTrait;

// From 'charcoal-app'
use Charcoal\App\Template\AbstractTemplate;

// From 'charcoal-cms'
use Charcoal\Cms\MetatagInterface;
use Charcoal\Cms\MetatagTrait;

// Local dependencies
use Boilerplate\Template\Partial\IncHeaderInterface;
use Boilerplate\Template\Partial\IncHeaderTrait;
use Boilerplate\Template\Partial\IncFooterInterface;
use Boilerplate\Template\Partial\IncFooterTrait;

/**
 * Base class for all "Boilerplate" templates.
 */
abstract class AbstractBoilerplateTemplate extends AbstractTemplate implements
    IncHeaderInterface,
    IncFooterInterface,
    MetatagInterface
{
    use IncHeaderTrait;
    use IncFooterTrait;
    use TranslatorAwareTrait;
    use MetatagTrait;

    /**
     * The application's configuration container.
     *
     * @var array|ArrayAccess
     */
    private $appConfig = [];

    /**
     * The base URI.
     *
     * @var UriInterface|null
     */
    private $baseUrl;

    /**
     * Whether the debug mode is enabled.
     *
     * @var boolean
     */
    private $debug = false;

    /**
     * The cache of parsed template names.
     *
     * @var array
     */
    protected static $templateNameCache = [];

    /**
     * @param  Container $container The pimple DI container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        // Fulfill Local dependencies requirements
        $this->setAppConfig($container['config']);
        $this->setBaseUrl($container['base-url']);
        $this->setDebug($container['debug']);

        // Fulfill TranslatorAwareTrait dependencies requirements
        $this->setTranslator($container['translator']);
    }

    /**
     * Set the application's configset.
     *
     * @param  array|ArrayAccess $config A configset.
     * @throws InvalidArgumentException If the configset is invalid.
     * @return void
     */
    private function setAppConfig($config)
    {
        if (!is_array($config) && !($config instanceof ArrayAccess)) {
            throw new InvalidArgumentException('The configset must be array-accessible.');
        }

        $this->appConfig = $config;
    }

    /**
     * Retrieve the application's configset.
     *
     * @param  string|null $key     Optional data key to retrieve from the configset.
     * @param  mixed|null  $default The default value to return if data key does not exist.
     * @return mixed
     */
    protected function appConfig($key = null, $default = null)
    {
        if ($key) {
            if (isset($this->appConfig[$key])) {
                return $this->appConfig[$key];
            } else {
                if (!is_string($default) && is_callable($default)) {
                    return $default();
                } else {
                    return $default;
                }
            }
        }

        return $this->appConfig;
    }

    /**
     * Set the base URI of the project.
     *
     * @see    \Charcoal\App\ServiceProvider\AppServiceProvider `$container['base-url']`
     * @param  UriInterface $uri The base URI.
     * @return void
     */
    private function setBaseUrl(UriInterface $uri)
    {
        $this->baseUrl = $uri;
    }

    /**
     * Retrieve the base URI of the project.
     *
     * @throws RuntimeException If the base URI is missing.
     * @return UriInterface|null
     */
    public function baseUrl()
    {
        if (!isset($this->baseUrl)) {
            throw new RuntimeException(sprintf(
                'The base URI is not defined for [%s]',
                get_class($this)
            ));
        }

        return $this->baseUrl;
    }



    /**
     * Prepend the base URI to the given path.
     *
     * @param  string $uri A URI path to wrap.
     * @return UriInterface
     */
    public function withBaseUrl($uri)
    {
        $uri = strval($uri);
        if ($uri && !parse_url($uri, PHP_URL_SCHEME)) {
            if (!in_array($uri[0], [ '/', '#', '?' ])) {
                return $this->baseUrl()->withPath($uri);
            }
        } else {
            return $this->baseUrl()->withPath('');
        }

        return $uri;
    }

    /**
     * Set application debug mode.
     *
     * @param  boolean $debug The debug flag.
     * @return void
     */
    private function setDebug($debug)
    {
        $this->debug = !!$debug;
    }

    /**
     * Retrieve the application debug mode.
     *
     * @return boolean
     */
    public function debug()
    {
        return $this->debug;
    }

    /**
     * @return string
     */
    public function canonicalUrl()
    {
        return '';
    }

    /**
     * Retrieve the current locale's language code.
     * * Ex: "en" or "fr"
     *
     * @return string
     */
    public function lang()
    {
        return $this->translator()->getLocale();
    }

    /**
     * @return array
     */
    public function meta()
    {
        return [

        ];
    }

    // Front-end helpers
    // ============================================================

    /**
     * Retrieve the template's identifier.
     *
     * @return string
     */
    public function templateName()
    {
        $key = substr(strrchr('\\'.get_class($this), '\\'), 1);

        if (!isset(static::$templateNameCache[$key])) {
            $value = $key;

            if (!ctype_lower($value)) {
                $value = preg_replace('/\s+/u', '', $value);
                $value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1-', $value), 'UTF-8');
            }

            $value = str_replace(
                [ 'abstract', 'trait', 'interface', 'template', '\\' ],
                '',
                $value
            );

            static::$templateNameCache[$key] = trim($value, '-');
        }

        return static::$templateNameCache[$key];
    }
}
