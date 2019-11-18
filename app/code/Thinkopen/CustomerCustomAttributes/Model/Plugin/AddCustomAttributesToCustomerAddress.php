<?php
/**
 * @package Thinkopen
 * @author Paolo
 */

declare(strict_types=1);

namespace Thinkopen\CustomerCustomAttributes\Model\Plugin;

use Magento\Framework\Api\AttributeInterface;

/**
 * Plugin for converting customer address custom attributes
 */
class AddCustomAttributesToCustomerAddress
{
    /**
     * @var \Thinkopen\CustomerCustomAttributes\Helper\Data
     */
    private $customerData;

    /**
     * @param \Thinkopen\CustomerCustomAttributes\Helper\Data $customerData
     */
    public function __construct(
        \Thinkopen\CustomerCustomAttributes\Helper\Data $customerData
    ) {
        $this->customerData = $customerData;
    }

    /**
     * @param \Magento\Customer\Model\Address $subject
     * @param \Magento\Customer\Api\Data\AddressInterface $customerAddress
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeUpdateData(
        \Magento\Customer\Model\Address $subject,
        \Magento\Customer\Api\Data\AddressInterface $customerAddress
    ) : array {
        $attributes = $this->customerData->getCustomerAddressUserDefinedAttributeCodes();
        $values = $customerAddress->getCustomAttributes();
        foreach ($attributes as $attribute) {
            if (!empty($values[$attribute]) && !($values[$attribute] instanceof AttributeInterface)) {
                $customerAddress->setCustomAttribute($attribute, $values[$attribute]);
            }
        }
        return [$customerAddress];
    }
}
