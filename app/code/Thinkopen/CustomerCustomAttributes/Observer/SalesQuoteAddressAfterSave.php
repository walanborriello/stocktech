<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesQuoteAddressAfterSave implements ObserverInterface
{
    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\AddressFactory
     */
    protected $quoteAddressFactory;

    /**
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\AddressFactory $quoteAddressFactory
     */
    public function __construct(
        \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\AddressFactory $quoteAddressFactory
    ) {
        $this->quoteAddressFactory = $quoteAddressFactory;
    }

    /**
     * After save observer for quote address
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quoteAddress = $observer->getEvent()->getQuoteAddress();
        if ($quoteAddress instanceof \Magento\Framework\Model\AbstractModel) {
            /** @var $quoteAddressModel \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\Address */
            $quoteAddressModel = $this->quoteAddressFactory->create();
            $quoteAddressModel->saveAttributeData($quoteAddress);
        }
        return $this;
    }
}
