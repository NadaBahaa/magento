<?php
namespace Vendor\SimpleEntity\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Vendor\SimpleEntity\Model\EntityFactory;

class Save extends Action
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
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            // Handle UI Component form data structure
            if (isset($data['data'])) {
                $data = $data['data'];
            }

            $id = isset($data['entity_id']) ? $data['entity_id'] : null;
            $model = $this->entityFactory->create();

            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This entity no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the entity.'));
                
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
        }
        return $resultRedirect->setPath('*/*/');
    }
}

