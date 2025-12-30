<?php
namespace Vendor\SampleItem\Api;

use Vendor\SampleItem\Model\SampleItem;

interface SampleItemRepositoryInterface
{
    public function getById(int $id): SampleItem;
    public function save(SampleItem $item): SampleItem;
    public function deleteById(int $id): bool;
}
