<?php
namespace Vendor\KitchenGallery\Model\Kitchen;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Vendor\KitchenGallery\Model\ResourceModel\Kitchen\CollectionFactory;

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
     * @var Registry
     */
    protected $registry;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param Registry $registry
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Registry $registry,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->registry = $registry;
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
        
        // Get model from registry (set by Edit controller)
        $model = $this->registry->registry('current_kitchen');
        
        if ($model) {
            // Model exists in registry (either new or existing)
            $modelData = $model->getData();
            $modelId = $model->getId();
            
            // Ensure entity_id is in the data array
            if (!isset($modelData['entity_id'])) {
                $modelData['entity_id'] = $modelId;
            }
            
            // Ensure all required fields exist with default values
            if (!isset($modelData['is_active'])) {
                $modelData['is_active'] = 1;
            }
            
            // Use ID as key if exists, otherwise empty string for new entities
            $key = $modelId ? $modelId : '';
            $this->loadedData[$key] = $modelData;
        } else {
            // Model not in registry - check data persistor for form errors
            $data = $this->dataPersistor->get('vendor_kitchengallery_kitchen');
            if (!empty($data)) {
                // Ensure entity_id exists in persisted data
                if (!isset($data['entity_id'])) {
                    $data['entity_id'] = null;
                }
                $this->loadedData[''] = $data;
                $this->dataPersistor->clear('vendor_kitchengallery_kitchen');
            } else {
                // New entity - return empty data structure with defaults
                // Always return data, even for new entities
                $this->loadedData[''] = [
                    'entity_id' => null,
                    'title' => '',
                    'author' => '',
                    'image' => '',
                    'category_id' => null,
                    'content' => '',
                    'is_active' => 1
                ];
            }
        }

        // Ensure we always return data (never empty array)
        if (empty($this->loadedData)) {
            $this->loadedData[''] = [
                'entity_id' => null,
                'is_active' => 1
            ];
        }

        return $this->loadedData;
    }
}

