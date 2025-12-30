<?php
namespace Vendor\KitchenGallery\Model\Kitchen\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Vendor\KitchenGallery\Model\ResourceModel\Category\CollectionFactory;

class Category implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $collection = $this->collectionFactory->create();
        
        foreach ($collection as $category) {
            $options[] = [
                'value' => $category->getId(),
                'label' => $category->getTitle()
            ];
        }

        return $options;
    }
}

