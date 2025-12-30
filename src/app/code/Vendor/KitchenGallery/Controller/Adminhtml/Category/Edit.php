<?php
namespace Vendor\KitchenGallery\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Vendor\KitchenGallery\Model\CategoryFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Vendor_KitchenGallery::category';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CategoryFactory $categoryFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CategoryFactory $categoryFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->categoryFactory = $categoryFactory;
        $this->registry = $registry;
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->categoryFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This category no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            // Set default values for new entity
            $model->setData('is_active', 1);
            // Ensure entity_id is explicitly set to null for new entities
            $model->setData('entity_id', null);
        }

        // Always register model in registry for DataProvider (even if empty)
        // This ensures DataProvider can always find the model
        $this->registry->register('current_category', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vendor_KitchenGallery::category');
        $resultPage->getConfig()->getTitle()->prepend(
            $id ? __('Edit Category') : __('New Category')
        );

        return $resultPage;
    }
}

