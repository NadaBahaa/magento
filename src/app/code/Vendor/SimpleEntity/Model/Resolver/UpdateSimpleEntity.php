<?php
namespace Vendor\SimpleEntity\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\SimpleEntity\Model\EntityFactory;

class UpdateSimpleEntity implements ResolverInterface
{
    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        EntityFactory $entityFactory
    ) {
        $this->entityFactory = $entityFactory;
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
        if (!isset($args['id']) || !$args['id']) {
            throw new GraphQlInputException(__('Entity ID is required.'));
        }

        $entity = $this->entityFactory->create();
        $entity->load($args['id']);

        if (!$entity->getId()) {
            throw new GraphQlInputException(__('Entity with ID "%1" does not exist.', $args['id']));
        }

        if (isset($args['name'])) {
            $entity->setName($args['name']);
        }
        
        if (isset($args['image'])) {
            $entity->setImage($args['image']);
        }
        
        if (isset($args['is_active'])) {
            $entity->setIsActive((int)$args['is_active']);
        }

        try {
            $entity->save();
        } catch (\Exception $e) {
            throw new GraphQlInputException(__('Unable to update entity: %1', $e->getMessage()));
        }

        return [
            'id' => (int)$entity->getId(),
            'name' => $entity->getName(),
            'image' => $entity->getImage(),
            'is_active' => (bool)$entity->getIsActive(),
        ];
    }
}

