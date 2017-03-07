<?php

namespace Boilerplate\Template;

use ArrayAccess;
use RuntimeException;
use InvalidArgumentException;

// Dependency from Pimple
use \Pimple\Container;

// Dependency from PSR-7
use Psr\Http\Message\UriInterface;

// Dependency from 'charcoal-config'
use \Charcoal\Config\ConfigInterface;

// Dependencies from 'charcoal-translator'
use \Charcoal\Translator\Translation;
use \Charcoal\Translator\TranslatorAwareTrait;

// Dependency from 'charcoal-app'
use \Charcoal\App\Template\AbstractTemplate;

// Local dependencies
use \Boilerplate\Template\IncHeaderInterface;
use \Boilerplate\Template\IncHeaderTrait;
use \Boilerplate\Template\IncFooterInterface;
use \Boilerplate\Template\IncFooterTrait;

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
    }

    /**
     * @param  ConfigInterface $config Main app config.
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
}