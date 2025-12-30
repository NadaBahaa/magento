<?php
namespace Vendor\SampleItem\Model\ResourceModel\SampleItem;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Vendor\SampleItem\Model\SampleItem::class,
            \Vendor\SampleItem\Model\ResourceModel\SampleItem::class
        );
    }
}
