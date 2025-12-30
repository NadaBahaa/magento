<?php
namespace Vendor\SimpleEntity\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Entity extends AbstractDb
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('vendor_simple_entity', 'entity_id');
    }
}

