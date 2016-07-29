<?php

namespace Boilerplate;

// Dependencies from Pimple
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Boilerplate Service Provider
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the boilerplate's required services.
     *
     * @param Container $container A DI container.
     * @return void
     */
    public function register(Container $container)
    {
    }
}
