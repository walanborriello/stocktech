<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Model\Sales;

/**
 * Customer Quote model
 *
 * @method \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote setEntityId(int $value)
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Quote extends AbstractSales
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Thinkopen\CustomerCustomAttributes\Model\ResourceModel\Sales\Quote::class);
    }
}
