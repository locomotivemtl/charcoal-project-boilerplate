<?php

namespace Boilerplate\Template;

use ArrayAccess;
use RuntimeException;
use InvalidArgumentException;

// Dependency from Pimple
use Pimple\Container;

// Dependency from PSR-7
use Psr\Http\Message\UriInterface;

// Dependency from 'charcoal-config'
use Charcoal\Config\ConfigInterface;

// Dependencies from 'charcoal-translator'
use Charcoal\Translator\Translation;
use Charcoal\Translator\TranslatorAwareTrait;

// Dependency from 'charcoal-app'
use Charcoal\App\Template\AbstractTemplate;

// Local dependencies
use Boilerplate\Template\IncHeaderInterface;
use Boilerplate\Template\IncHeaderTrait;
use Boilerplate\Template\IncFooterInterface;
use Boilerplate\Template\IncFooterTrait;

/**
 * Base class for all "Boilerplate" templates.
 */
abstract class AbstractBoilerplateTemplate extends AbstractTemplate implements
    IncHeaderInterface,
    IncFooterInterface
{
    use IncHeaderTrait;
    use IncFooterTrait;
    use TranslatorAwareTrait;

    /**
     * The base URI.
     *
     * @var UriInterface|null
     */
    private $baseUrl;

    /**
     * The application's configuration container.
     *
     * @var array|ArrayAccess
     */
    private $appConfig = [];

    /**
     * Whether the debug mode is enabled.
     *
     * @var boolean
     */
    private $debug = false;

    /**
     * @var Parser $browserParser
     */
    private $browserParser;

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

        $this->setDebug($container['debug']);
        $this->setBaseUrl($container['base-url']);
        $this->setAppConfig($container['config']);
        $this->setTranslator($container['translator']);
        $this->setBrowserParser($container['browserparser']);
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
     * @param Parser $loader From dependencies container.
     */
    public function setBrowserParser($parser)
    {
        $this->browserParser = $parser;

        return $this;
    }

    /**
     * @return Parser Set from dependencies container.
     */
    public function browserParser()
    {
        return $this->browserParser;
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
     * Retrieve the current locale's landguage code.
     *
     * @return string
     */
    public function lang()
    {
        return $this->translator()->getLocale();
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

    /**
     * Use BrowserParser to determine if is iOS.
     *
     * @return boolean
     */
    public function isIos()
    {
        return $this->browserParser()->isOs('iOS');
    }

    /**
     * Use BrowserParser to determine if is IE9
     *
     * @return boolean
     */
    public function isIe9()
    {
        return $this->browserParser()->isBrowser('Internet Explorer', '<', '10');
    }

    /**
     * Use BrowserParser to determine if is IE10
     *
     * @return boolean
     */
    public function isIe10()
    {
        return $this->browserParser()->isBrowser('Internet Explorer', '=', '10');
    }

    /**
     * Use BrowserParser to determine if is Internet Explorer
     *
     * @return boolean
     */
    public function isIe()
    {
        return  $this->browserParser()->isBrowser('Internet Explorer') ||
                $this->browserParser()->isBrowser('Edge');
    }
}
