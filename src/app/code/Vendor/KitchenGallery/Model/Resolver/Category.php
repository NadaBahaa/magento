<?php
namespace Vendor\KitchenGallery\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\KitchenGallery\Model\CategoryFactory;

class Category implements ResolverInterface
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
            throw new \Magento\Framework\GraphQl\Exception\GraphQlInputException(__('Category ID is required.'));
        }

        $category = $this->categoryFactory->create();
        $category->load($args['id']);

        if (!$category->getId()) {
            throw new \Magento\Framework\GraphQl\Exception\GraphQlInputException(__('Category with ID "%1" does not exist.', $args['id']));
        }

        return [
            'id' => (int)$category->getId(),
            'title' => $category->getTitle(),
            'is_active' => (bool)$category->getIsActive(),
        ];
    }
}

