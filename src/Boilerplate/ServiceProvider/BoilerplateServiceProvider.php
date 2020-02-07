<?php

namespace Boilerplate\ServiceProvider;

// From 'pimple/pimple'
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
        $container->register(new \Charcoal\Cache\ServiceProvider\CacheServiceProvider());
        $container->register(new \Charcoal\Email\ServiceProvider\EmailServiceProvider());
        $container->register(new \Charcoal\Model\ServiceProvider\ModelServiceProvider());
        $container->register(new \Charcoal\Translator\ServiceProvider\TranslatorServiceProvider());
        $container->register(new \Charcoal\Ui\ServiceProvider\UiServiceProvider());

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
