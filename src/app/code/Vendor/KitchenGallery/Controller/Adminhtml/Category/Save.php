<?php
namespace Vendor\KitchenGallery\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Vendor\KitchenGallery\Model\CategoryFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Vendor_KitchenGallery::category';

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @param Context $context
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory
    ) {
        parent::__construct($context);
        $this->categoryFactory = $categoryFactory;
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
        $model = $this->categoryFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This category no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('You saved the category.'));
            
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

