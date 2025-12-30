<?php
namespace Vendor\KitchenGallery\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Vendor\KitchenGallery\Model\CategoryFactory;

class Delete extends Action
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
                $model = $this->categoryFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the category.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}

