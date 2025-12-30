<?php
namespace Vendor\SimpleEntity\Model\Entity;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Vendor\SimpleEntity\Model\EntityFactory;
use Vendor\SimpleEntity\Model\ResourceModel\Entity\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param RequestInterface $request
     * @param EntityFactory $entityFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        RequestInterface $request,
        EntityFactory $entityFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
        $this->entityFactory = $entityFactory;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $this->loadedData = [];
        $entity = $this->getCurrentEntity();
        $entityId = $entity->getId();
        
        // Get entity data
        $entityData = $entity->getData();
        
        // Ensure entity_id is always set, even if null for new entities
        if (!isset($entityData['entity_id'])) {
            $entityData['entity_id'] = $entityId;
        }
        
        // Use empty string key for new entities, or actual ID for existing
        $key = $entityId !== null ? $entityId : '';
        $this->loadedData[$key] = $entityData;

        return $this->loadedData;
    }

    /**
     * Return current entity
     *
     * @return \Vendor\SimpleEntity\Model\Entity
     */
    private function getCurrentEntity()
    {
        $entityId = $this->request->getParam($this->getRequestFieldName());
        
        if ($entityId) {
            $entity = $this->entityFactory->create();
            $entity->load($entityId);
            if ($entity->getId()) {
                return $entity;
            }
        }

        $data = $this->dataPersistor->get('vendor_simple_entity');
        if (empty($data)) {
            $entity = $this->entityFactory->create();
            // Set default values for new entity
            $entity->setData('is_active', 1);
            return $entity;
        }
        
        $this->dataPersistor->clear('vendor_simple_entity');
        
        $entity = $this->entityFactory->create();
        $entity->setData($data);
        
        return $entity;
    }
}

