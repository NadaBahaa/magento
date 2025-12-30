<?php
namespace Vendor\KitchenGallery\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\KitchenGallery\Model\KitchenFactory;

class UpdateKitchen implements ResolverInterface
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

        if (isset($args['title'])) {
            $kitchen->setTitle($args['title']);
        }
        
        if (isset($args['author'])) {
            $kitchen->setAuthor($args['author']);
        }
        
        if (isset($args['image'])) {
            $kitchen->setImage($args['image']);
        }
        
        if (isset($args['category_id'])) {
            $kitchen->setCategoryId((int)$args['category_id']);
        }
        
        if (isset($args['content'])) {
            $kitchen->setContent($args['content']);
        }
        
        if (isset($args['is_active'])) {
            $kitchen->setIsActive((int)$args['is_active']);
        }

        try {
            $kitchen->save();
        } catch (\Exception $e) {
            throw new GraphQlInputException(__('Unable to update kitchen: %1', $e->getMessage()));
        }

        return [
            'id' => (int)$kitchen->getId(),
            'title' => $kitchen->getTitle(),
            'author' => $kitchen->getAuthor(),
            'image' => $kitchen->getImage(),
            'category_id' => $kitchen->getCategoryId() ? (int)$kitchen->getCategoryId() : null,
            'content' => $kitchen->getContent(),
            'is_active' => (bool)$kitchen->getIsActive(),
        ];
    }
}

