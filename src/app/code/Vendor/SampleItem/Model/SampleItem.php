<?php
namespace Vendor\SampleItem\Model;

use Magento\Framework\Model\AbstractModel;

class SampleItem extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Vendor\SampleItem\Model\ResourceModel\SampleItem::class);
    }
}
