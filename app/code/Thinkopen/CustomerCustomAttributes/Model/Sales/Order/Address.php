<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Model\Sales\Order;

/**
 * Customer Order Address model
 *
 * @method \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\Address setEntityId(int $value)
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Address extends \Thinkopen\CustomerCustomAttributes\Model\Sales\Address\AbstractAddress
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Thinkopen\CustomerCustomAttributes\Model\ResourceModel\Sales\Order\Address::class);
    }
}
