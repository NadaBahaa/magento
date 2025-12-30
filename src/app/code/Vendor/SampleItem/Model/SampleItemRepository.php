<?php
namespace Vendor\SampleItem\Model;

use Vendor\SampleItem\Api\SampleItemRepositoryInterface;
use Vendor\SampleItem\Model\ResourceModel\SampleItem as Resource;
use Vendor\SampleItem\Model\SampleItemFactory;

class SampleItemRepository implements SampleItemRepositoryInterface
{
    public function __construct(
        private Resource $resource,
        private SampleItemFactory $factory
    ) {}

    public function getById(int $id)
    {
        $item = $this->factory->create();
        $this->resource->load($item, $id);
        return $item;
    }

    public function save(SampleItem $item)
    {
        $this->resource->save($item);
        return $item;
    }

    public function deleteById(int $id): bool
    {
        $item = $this->getById($id);
        $this->resource->delete($item);
        return true;
    }
}
