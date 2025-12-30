<?php
namespace Vendor\KitchenGallery\Controller\Adminhtml\Kitchen;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Vendor\KitchenGallery\Model\KitchenFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Vendor_KitchenGallery::kitchens';

    /**
     * @var KitchenFactory
     */
    protected $kitchenFactory;

    /**
     * @param Context $context
     * @param KitchenFactory $kitchenFactory
     */
    public function __construct(
        Context $context,
        KitchenFactory $kitchenFactory
    ) {
        parent::__construct($context);
        $this->kitchenFactory = $kitchenFactory;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        // Handle UI Component form data structure
        if (isset($data['data'])) {
            $data = $data['data'];
        }

        $id = isset($data['entity_id']) ? $data['entity_id'] : null;
        $model = $this->kitchenFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This kitchen no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('You saved the kitchen.'));
            
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        if ($id) {
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

