<?php
namespace Vendor\SimpleEntity\Model\ResourceModel\Entity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     */
    protected function _construct()
    {
        $this->_init(
            \Vendor\SimpleEntity\Model\Entity::class,
            \Vendor\SimpleEntity\Model\ResourceModel\Entity::class
        );
    }
}

