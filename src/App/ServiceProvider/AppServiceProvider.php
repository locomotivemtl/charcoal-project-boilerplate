<?php

namespace App\ServiceProvider;

// From 'pimple/pimple'
use Pimple\Container;
use Pimple\ServiceProviderInterface;

// From 'charcoal-cache'
use Charcoal\Cache\ServiceProvider\CacheServiceProvider;

// From 'charcoal-email'
use Charcoal\Email\ServiceProvider\EmailServiceProvider;

// From 'charcoal-core'
use Charcoal\Model\ServiceProvider\ModelServiceProvider;

// From 'charcoal-translator'
use Charcoal\Translator\ServiceProvider\TranslatorServiceProvider;

// From 'charcoal-ui'
use Charcoal\Ui\ServiceProvider\UiServiceProvider;

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
        $container->register(new CacheServiceProvider());
        $container->register(new EmailServiceProvider());
        $container->register(new ModelServiceProvider());
        $container->register(new TranslatorServiceProvider());
        $container->register(new UiServiceProvider());

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
