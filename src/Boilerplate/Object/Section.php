<?php

namespace Boilerplate\Object;

// From Pimple
use Pimple\Container;

// From 'charcoal-core'
use Charcoal\Loader\CollectionLoader;

// From 'charcoal-attachment'
use Charcoal\Attachment\Traits\AttachmentAwareTrait;

// From 'charcoal-cms'
use Charcoal\Cms\AbstractSection;

/**
 * Class Section
 */
class Section extends AbstractSection
{
    use AttachmentAwareTrait;

    /**
     * @var CollectionLoader
     */
    private $collectionLoader;

    /**
     * @param Container $container Pimple DI Container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);
        $this->setCollectionLoader($container['model/collection/loader']);
    }

    /**
     * @param CollectionLoader $loader The collection loader to use.
     * @return void
     */
    private function setCollectionLoader(CollectionLoader $loader)
    {
        $this->collectionLoader = $loader;
    }

    /**
     * @return CollectionLoader
     */
    protected function collectionLoader()
    {
        return $this->collectionLoader;
    }
}
