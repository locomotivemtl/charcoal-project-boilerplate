<?php

namespace App\Object;

use App\Support\AdminAwareTrait;
use Pimple\Container;
use Charcoal\Attachment\Traits\AttachmentAwareTrait;
use Charcoal\Cms\AbstractSection;
use Charcoal\Loader\CollectionLoaderAwareTrait;

/**
 * Class Section
 */
class Section extends AbstractSection
{
    use AdminAwareTrait;
    use AttachmentAwareTrait;
    use CollectionLoaderAwareTrait;

    /**
     * @param  Container $container Pimple DI Container.
     * @return void
     */
    public function setDependencies(Container $container)
    {
        parent::setDependencies($container);
        $this->setCollectionLoader($container['model/collection/loader']);
    }
}
