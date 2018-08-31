<?php

namespace Boilerplate\ServiceProvider;

// From Pimple
use Pimple\Container;
use Pimple\ServiceProviderInterface;

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
    }
}
