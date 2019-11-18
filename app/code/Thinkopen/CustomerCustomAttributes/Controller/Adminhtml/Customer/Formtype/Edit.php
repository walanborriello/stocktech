<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Thinkopen\CustomerCustomAttributes\Controller\Adminhtml\Customer\Formtype;

class Edit extends \Thinkopen\CustomerCustomAttributes\Controller\Adminhtml\Customer\Formtype
{
    /**
     * Edit Form Type
     *
     * @return void
     */
    public function execute()
    {
        $this->_coreRegistry->register('edit_mode', 'edit');
        $this->_initFormType();
        $this->_initAction();
        $this->_view->renderLayout();
    }
}
