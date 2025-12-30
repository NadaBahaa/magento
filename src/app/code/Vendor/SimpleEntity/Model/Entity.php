<?php
namespace Vendor\SimpleEntity\Model;

use Magento\Framework\Model\AbstractModel;

class Entity extends AbstractModel
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(\Vendor\SimpleEntity\Model\ResourceModel\Entity::class);
    }
}

