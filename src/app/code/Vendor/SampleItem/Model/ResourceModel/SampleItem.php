<?php
namespace Vendor\SampleItem\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SampleItem extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vendor_sample_item', 'entity_id');
    }
}
