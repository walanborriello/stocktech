<?php

namespace Walan\FatturazioneElettronica\Model;

class CustomerCAttributes extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'customer_address_custom_attributes';

    protected $_cacheTag = 'customer_address_custom_attributes';

    protected $_eventPrefix = 'customer_address_custom_attributes';

    protected function _construct()
    {
        $this->_init('Walan\Addpecssid\Model\ResourceModel\CustomerCAttributes');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
