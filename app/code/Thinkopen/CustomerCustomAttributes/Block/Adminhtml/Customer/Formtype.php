<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Block\Adminhtml\Customer;

/**
 * Form Types Grid Container Block
 *
 * @api
 * @since 100.0.2
 */
class Formtype extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Block constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Thinkopen_CustomerCustomAttributes';
        $this->_controller = 'adminhtml_customer_formtype';
        $this->_headerText = __('Manage Form Types');

        parent::_construct();

        $this->buttonList->update('add', 'label', __('New Form Type'));
    }
}
