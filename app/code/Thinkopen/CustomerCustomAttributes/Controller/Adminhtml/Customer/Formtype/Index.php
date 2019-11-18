<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Thinkopen\CustomerCustomAttributes\Controller\Adminhtml\Customer\Formtype;

class Index extends \Thinkopen\CustomerCustomAttributes\Controller\Adminhtml\Customer\Formtype
{
    /**
     * View form types grid
     *
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->_view->renderLayout();
    }
}
