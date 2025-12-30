<?php
namespace Vendor\KitchenGallery\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(
            \Vendor\KitchenGallery\Model\Category::class,
            \Vendor\KitchenGallery\Model\ResourceModel\Category::class
        );
    }
}

