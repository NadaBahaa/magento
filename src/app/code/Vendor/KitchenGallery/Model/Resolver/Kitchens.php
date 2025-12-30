<?php
namespace Vendor\KitchenGallery\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\KitchenGallery\Model\ResourceModel\Kitchen\CollectionFactory;

class Kitchens implements ResolverInterface
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
        
        foreach ($collection as $kitchen) {
            $items[] = [
                'id' => (int)$kitchen->getId(),
                'title' => $kitchen->getTitle(),
                'author' => $kitchen->getAuthor(),
                'image' => $kitchen->getImage(),
                'category_id' => $kitchen->getCategoryId() ? (int)$kitchen->getCategoryId() : null,
                'content' => $kitchen->getContent(),
                'is_active' => (bool)$kitchen->getIsActive(),
            ];
        }

        return $items;
    }
}
