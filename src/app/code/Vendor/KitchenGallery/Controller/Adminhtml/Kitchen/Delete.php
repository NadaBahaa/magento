<?php
namespace Vendor\KitchenGallery\Controller\Adminhtml\Kitchen;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Vendor\KitchenGallery\Model\KitchenFactory;

class Delete extends Action
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
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            try {
                $model = $this->kitchenFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the kitchen.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}

