<?php
namespace Vendor\SampleItem\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;

class SampleItemResolver implements ResolverInterface
{
    public function __construct(
        private \Vendor\SampleItem\Model\ResourceModel\SampleItem\CollectionFactory $collectionFactory
    ) {}

    public function resolve($field, $context, $info, array $value = null, array $args = null)
    {
        $items = [];
        foreach ($this->collectionFactory->create() as $item) {
            $items[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'image' => $item->getImage(),
                'is_active' => (bool)$item->getIsActive()
            ];
        }
        return $items;
    }
}
