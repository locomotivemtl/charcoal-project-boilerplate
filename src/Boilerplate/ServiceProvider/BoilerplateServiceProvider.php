<?php

namespace Boilerplate\ServiceProvider;

// From Pimple
use Pimple\Container;
use Pimple\ServiceProviderInterface;

// From 'whichbrowser/parser'
use WhichBrowser\Parser as BrowserParser;

/**
 * Boilerplate Service Provider
 */
class BoilerplateServiceProvider implements ServiceProviderInterface
{
    /**
     * @param  Container $container Pimple DI Container.
     * @return void
     */
    public function register(Container $container)
    {
        // Boilerplate dependencies
        $container->register(new \Charcoal\Model\ServiceProvider\ModelServiceProvider());

        /**
         * BrowserParser helps to determine the environment in which we're running.
         *
         * @param Container $container Pimple DI Container
         * @return BrowserParser
         */
        $container['browserparser'] = function () {
            return new BrowserParser($_SERVER['HTTP_USER_AGENT']);
        };
    }
}
