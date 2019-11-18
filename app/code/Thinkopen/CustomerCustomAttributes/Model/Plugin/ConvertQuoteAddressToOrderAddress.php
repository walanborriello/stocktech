<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Model\Plugin;

class ConvertQuoteAddressToOrderAddress
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
     * @param \Magento\Quote\Model\Quote\Address\ToOrderAddress $subject
     * @param \Magento\Sales\Api\Data\OrderAddressInterface $result
     * @param \Magento\Quote\Api\Data\AddressInterface $quoteAddress
     * @param array $data
     * @return \Magento\Sales\Api\Data\OrderAddressInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterConvert(
        \Magento\Quote\Model\Quote\Address\ToOrderAddress $subject,
        \Magento\Sales\Api\Data\OrderAddressInterface $result,
        \Magento\Quote\Api\Data\AddressInterface $quoteAddress,
        $data = []
    ) {
        $attributes = $this->customerData->getCustomerAddressUserDefinedAttributeCodes();
        foreach ($attributes as $attribute) {
            $result->setData($attribute, $quoteAddress->getData($attribute));
        }
        return $result;
    }
}
