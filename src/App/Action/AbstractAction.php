<?php

namespace App\Action;

// From Pimple
use Pimple\Container;

// From PSR-7
use Psr\Http\Message\UriInterface;

// From 'charcoal-core'
use Charcoal\Model\ModelFactoryTrait;

// From 'charcoal-translator'
use Charcoal\Translator\TranslatorAwareTrait;

// From 'charcoal-app'
use Charcoal\App\AppConfig;
use Charcoal\App\DebugAwareTrait;
use Charcoal\App\Action\AbstractAction as CharcoalAction;

/**
 * Base API Controller
 */
abstract class AbstractAction extends CharcoalAction
{
    use DebugAwareTrait;
    use ModelFactoryTrait;
    use TranslatorAwareTrait;

    /**
     * The application's configuration container.
     *
     * @var AppConfig
     */
    protected $appConfig;

    /**
     * The base URI.
     *
     * @var UriInterface|null
     */
    protected $baseUrl;



    // Request
    // -------------------------------------------------------------------------



    // Response
    // -------------------------------------------------------------------------



    // Dependencies
    // -------------------------------------------------------------------------

    /**
     * Set the application's configset.
     *
     * @param  AppConfig $appConfig A Charcoal application configset.
     * @return self
     */
    protected function setAppConfig(AppConfig $appConfig)
    {
        $this->appConfig = $appConfig;

        return $this;
    }

    /**
     * Retrieve the application's configset or a specific setting.
     *
     * @param  string|null $key     Optional data key to retrieve from the configset.
     * @param  mixed|null  $default The default value to return if data key does not exist.
     * @return mixed|AppConfig|SettingsInterface
     */
    public function appConfig($key = null, $default = null)
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
     * @param  UriInterface $uri A URI.
     * @return void
     */
    protected function setBaseUrl(UriInterface $uri)
    {
        $this->baseUrl = $uri;
    }

    /**
     * @return UriInterface
     */
    public function baseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Give an opportunity to children classes to inject dependencies from a Pimple Container.
     *
     * Does nothing by default, reimplement in children classes.
     *
     * The `$container` DI-container (from `Pimple`) should not be saved or passed around, only to be used to
     * inject dependencies (typically via setters).
     *
     * @param Container $container A dependencies container instance.
     * @return void
     */
    protected function setDependencies(Container $container)
    {
        $this->setTranslator($container['translator']);
        $this->setDebug($container['debug']);
        $this->setBaseUrl($container['base-url']);
        $this->setAppConfig($container['app/site']);
    }
}
