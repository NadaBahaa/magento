<?php
namespace Vendor\KitchenGallery\Model;

use Magento\Framework\Model\AbstractModel;

class Kitchen extends AbstractModel
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(\Vendor\KitchenGallery\Model\ResourceModel\Kitchen::class);
    }
}

