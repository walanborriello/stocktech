<?php
/**
 * @package Thinkopen
 * @author Paolo
 */

/**
 * Thinkopen Customer Data Helper
 *
 */
namespace Thinkopen\CustomerCustomAttributes\Helper;

class Address extends \Thinkopen\CustomAttributeManagement\Helper\Data
{
    /**
     * Default attribute entity type code
     *
     * @return string
     */
    protected function _getEntityTypeCode()
    {
        return 'customer_address';
    }

    /**
     * Return available customer address attribute form as select options
     *
     * @return array
     */
    public function getAttributeFormOptions()
    {
        return [
            ['label' => __('Customer Address Registration'), 'value' => 'customer_register_address'],
            ['label' => __('Customer Account Address'), 'value' => 'customer_address_edit']
        ];
    }
}
