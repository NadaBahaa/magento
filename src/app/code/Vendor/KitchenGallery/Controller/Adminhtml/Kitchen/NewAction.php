<?php
namespace Vendor\KitchenGallery\Controller\Adminhtml\Kitchen;

use Magento\Backend\App\Action;

class NewAction extends Action
{
    const ADMIN_RESOURCE = 'Vendor_KitchenGallery::kitchens';

    /**
     * Create new kitchen - forward to edit
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->_forward('edit');
    }
}

