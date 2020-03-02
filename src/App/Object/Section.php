<?php

namespace App\Object;

// From 'pimple/pimple'
use Pimple\Container;

// From 'charcoal-core'
use Charcoal\Loader\CollectionLoaderAwareTrait;

// From 'charcoal-attachment'
use Charcoal\Attachment\Traits\AttachmentAwareTrait;

// From 'charcoal-cms'
use Charcoal\Cms\AbstractSection;

// From App
use App\Support\AdminAwareTrait;

/**
 * Class Section
 */
class Section extends AbstractSection
{
    use AdminAwareTrait;
    use AttachmentAwareTrait;
    use CollectionLoaderAwareTrait;

    /**
     * @param Container $container Pimple DI Container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);
        $this->setCollectionLoader($container['model/collection/loader']);
    }
}
