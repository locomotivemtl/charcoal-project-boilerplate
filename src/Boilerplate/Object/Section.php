<?php

namespace Boilerplate\Object;

// Dependencies from 'pimple'
use Pimple\Container;

// Dependencies from 'charcoal-core'
use Charcoal\Loader\CollectionLoader;

// Dependencies from 'charcoal-attachment'
use Charcoal\Attachment\Traits\AttachmentAwareTrait;

// Dependencies from 'charcoal-cms'
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
     * @param Container $container
     * *return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);
        $this->setCollectionLoader($container['model/collection/loader']);
    }

    /**
     * @param CollectionLoader $loader
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
