<?php
namespace Vendor\SimpleEntity\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\SimpleEntity\Model\ResourceModel\Entity\CollectionFactory;

class SimpleEntities implements ResolverInterface
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
        
        foreach ($collection as $entity) {
            $items[] = [
                'id' => (int)$entity->getId(),
                'name' => $entity->getName(),
                'image' => $entity->getImage(),
                'is_active' => (bool)$entity->getIsActive(),
            ];
        }

        return $items;
    }
}

