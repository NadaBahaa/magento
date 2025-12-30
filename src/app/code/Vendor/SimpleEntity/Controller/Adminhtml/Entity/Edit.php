<?php
namespace Vendor\SimpleEntity\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\SimpleEntity\Model\EntityFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Vendor_SimpleEntity::entity';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        EntityFactory $entityFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->entityFactory = $entityFactory;
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->entityFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This entity no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vendor_SimpleEntity::entity');
        $resultPage->getConfig()->getTitle()->prepend(
            $id ? __('Edit Entity') : __('New Entity')
        );

        return $resultPage;
    }
}

