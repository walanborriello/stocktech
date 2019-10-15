<?php

namespace Walan\FatturazioneElettronica\Model\ResourceModel;

class CustomerCAttributes extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('customer_address_custom_attributes', 'id');
    }
}
