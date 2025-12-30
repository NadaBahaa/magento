<?php
namespace Vendor\KitchenGallery\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\KitchenGallery\Model\ResourceModel\Category\CollectionFactory;

class Categories implements ResolverInterface
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
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $items = [];
        $collection = $this->collectionFactory->create();
        
        foreach ($collection as $category) {
            $items[] = [
                'id' => (int)$category->getId(),
                'title' => $category->getTitle(),
                'is_active' => (bool)$category->getIsActive(),
                'created_at' => $category->getCreatedAt(),
                'updated_at' => $category->getUpdatedAt()
            ];
        }

        return $items;
    }
}

