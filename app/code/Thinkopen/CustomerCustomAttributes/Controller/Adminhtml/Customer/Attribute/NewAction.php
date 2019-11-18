<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Thinkopen\CustomerCustomAttributes\Controller\Adminhtml\Customer\Attribute;

class NewAction extends \Thinkopen\CustomerCustomAttributes\Controller\Adminhtml\Customer\Attribute
{
    /**
     * Create new attribute action
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->addActionLayoutHandles();
        $this->_forward('edit');
    }
}
