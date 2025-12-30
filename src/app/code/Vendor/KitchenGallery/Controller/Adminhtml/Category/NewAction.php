<?php
namespace Vendor\KitchenGallery\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;

class NewAction extends Action
{
    const ADMIN_RESOURCE = 'Vendor_KitchenGallery::category';

    /**
     * Create new category - forward to edit
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->_forward('edit');
    }
}

