<?php
namespace Vendor\KitchenGallery\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Kitchen extends AbstractDb
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('vendor_kitchengallery_kitchen', 'entity_id');
    }
}

