<?php
namespace Vendor\SimpleEntity\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\SimpleEntity\Model\EntityFactory;

class CreateSimpleEntity implements ResolverInterface
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
        if (!isset($args['name']) || empty($args['name'])) {
            throw new GraphQlInputException(__('Name is required.'));
        }

        $entity = $this->entityFactory->create();
        $entity->setName($args['name']);
        
        if (isset($args['image'])) {
            $entity->setImage($args['image']);
        }
        
        $entity->setIsActive(isset($args['is_active']) ? (int)$args['is_active'] : 1);

        try {
            $entity->save();
        } catch (\Exception $e) {
            throw new GraphQlInputException(__('Unable to create entity: %1', $e->getMessage()));
        }

        return [
            'id' => (int)$entity->getId(),
            'name' => $entity->getName(),
            'image' => $entity->getImage(),
            'is_active' => (bool)$entity->getIsActive(),
        ];
    }
}

