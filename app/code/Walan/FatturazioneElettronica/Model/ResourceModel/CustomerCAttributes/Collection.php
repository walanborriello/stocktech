<?php

namespace Walan\FatturazioneElettronica\Model\ResourceModel\CustomerCAttributes;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'customer_address_custom_attributes_index_collection';
    protected $_eventObject = 'collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Walan\Addpecssid\Model\CustomerCAttributes', 'Walan\Addpecssid\Model\ResourceModel\CustomerCAttributes');
    }
}
