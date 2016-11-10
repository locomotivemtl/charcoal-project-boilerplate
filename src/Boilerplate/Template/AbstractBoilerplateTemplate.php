<?php

namespace Boilerplate\Template;

use \Pimple\Container;

// Dependency from 'charcoal-config'
use \Charcoal\Config\ConfigInterface;

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

    /**
     * @var ConfigInterface $translationConfig
     */
    private $translationConfig;

    /**
     * @param Container $container The pimple DI container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);

        $this->setAppConfig($container['config']);
        $this->setTranslationConfig($container['translator/config']);
    }

    /**
     * @param ConfigInterface $config Main app config.
     * @return void
     */
    private function setAppConfig(ConfigInterface $config)
    {
        $this->appConfig = $config;
    }

    /**
     * @return ConfigInterface
     */
    protected function appConfig()
    {
        return $this->appConfig;
    }

    /**
     * @param ConfigInterface $config The translaction config object (translator).
     * @return void
     */
    private function setTranslationConfig(ConfigInterface $config)
    {
        $this->translationConfig = $config;
    }

    /**
     * @return ConfigInterface
     */
    protected function translationConfig()
    {
        return $this->translationConfig;
    }

    /**
     * @return string
     */
    public function baseUrl()
    {
        return $this->appConfig()->baseUrl();
    }

    /**
     * Get the current language code.
     *
     * @return string
     */
    public function lang()
    {
        return $this->translationConfig()->currentLanguage();
    }
}
