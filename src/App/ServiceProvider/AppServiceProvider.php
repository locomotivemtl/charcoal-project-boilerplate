<?php

namespace App\ServiceProvider;

// From 'pimple/pimple'
use Pimple\Container;
use Pimple\ServiceProviderInterface;

// From 'charcoal-email'
use Charcoal\Email\ServiceProvider\EmailServiceProvider;

// From 'charcoal-core'
use Charcoal\Model\ServiceProvider\ModelServiceProvider;

/**
 * App Service Provider
 */
class AppServiceProvider implements ServiceProviderInterface
{
    /**
     * @param  Container $container Pimple DI Container.
     * @return void
     */
    public function register(Container $container)
    {
        $container->register(new EmailServiceProvider());
        $container->register(new ModelServiceProvider());

        $container->extend('view/mustache/helpers', function (array $helpers, Container $container) {
            unset($container);
            $helper = [
                /**
                 * Retrieve the current date/time.
                 *
                 * @return array
                 */
                'now' => [
                    'year' => date('Y'),
                ],
            ];
            return array_merge($helpers, $helper);
        });
    }
}
