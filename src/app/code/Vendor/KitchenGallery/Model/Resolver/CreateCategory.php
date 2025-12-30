<?php
namespace Vendor\KitchenGallery\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\KitchenGallery\Model\CategoryFactory;

class CreateCategory implements ResolverInterface
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
        if (!isset($args['title']) || empty($args['title'])) {
            throw new GraphQlInputException(__('Title is required.'));
        }

        $category = $this->categoryFactory->create();
        $category->setTitle($args['title']);
        $category->setIsActive(isset($args['is_active']) ? (int)$args['is_active'] : 1);

        try {
            $category->save();
        } catch (\Exception $e) {
            throw new GraphQlInputException(__('Unable to create category: %1', $e->getMessage()));
        }

        return [
            'id' => (int)$category->getId(),
            'title' => $category->getTitle(),
            'is_active' => (bool)$category->getIsActive(),
        ];
    }
}

