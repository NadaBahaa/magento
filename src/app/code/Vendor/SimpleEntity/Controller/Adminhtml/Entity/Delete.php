<?php
namespace Vendor\SimpleEntity\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Vendor\SimpleEntity\Model\EntityFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Vendor_SimpleEntity::entity';

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @param Context $context
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        Context $context,
        EntityFactory $entityFactory
    ) {
        parent::__construct($context);
        $this->entityFactory = $entityFactory;
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
                $model = $this->entityFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the entity.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}

