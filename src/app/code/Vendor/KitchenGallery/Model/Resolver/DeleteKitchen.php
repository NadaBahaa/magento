<?php
namespace Vendor\KitchenGallery\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\KitchenGallery\Model\KitchenFactory;

class DeleteKitchen implements ResolverInterface
{
    /**
     * @var KitchenFactory
     */
    protected $kitchenFactory;

    /**
     * @param KitchenFactory $kitchenFactory
     */
    public function __construct(
        KitchenFactory $kitchenFactory
    ) {
        $this->kitchenFactory = $kitchenFactory;
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
            throw new GraphQlInputException(__('Kitchen ID is required.'));
        }

        $kitchen = $this->kitchenFactory->create();
        $kitchen->load($args['id']);

        if (!$kitchen->getId()) {
            throw new GraphQlInputException(__('Kitchen with ID "%1" does not exist.', $args['id']));
        }

        try {
            $kitchen->delete();
        } catch (\Exception $e) {
            throw new GraphQlInputException(__('Unable to delete kitchen: %1', $e->getMessage()));
        }

        return true;
    }
}

