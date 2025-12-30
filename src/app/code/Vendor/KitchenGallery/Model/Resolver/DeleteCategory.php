<?php
namespace Vendor\KitchenGallery\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\KitchenGallery\Model\CategoryFactory;

class DeleteCategory implements ResolverInterface
{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        CategoryFactory $categoryFactory
    ) {
        $this->categoryFactory = $categoryFactory;
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
            throw new GraphQlInputException(__('Category ID is required.'));
        }

        $category = $this->categoryFactory->create();
        $category->load($args['id']);

        if (!$category->getId()) {
            throw new GraphQlInputException(__('Category with ID "%1" does not exist.', $args['id']));
        }

        try {
            $category->delete();
        } catch (\Exception $e) {
            throw new GraphQlInputException(__('Unable to delete category: %1', $e->getMessage()));
        }

        return true;
    }
}

