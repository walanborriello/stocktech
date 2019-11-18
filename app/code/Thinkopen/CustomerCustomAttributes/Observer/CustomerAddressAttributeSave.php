<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomerAddressAttributeSave implements ObserverInterface
{
    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\AddressFactory
     */
    protected $orderAddressFactory;

    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\AddressFactory
     */
    protected $quoteAddressFactory;

    /**
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\AddressFactory $orderAddressFactory
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\AddressFactory $quoteAddressFactory
     */
    public function __construct(
        \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\AddressFactory $orderAddressFactory,
        \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\AddressFactory $quoteAddressFactory
    ) {
        $this->orderAddressFactory = $orderAddressFactory;
        $this->quoteAddressFactory = $quoteAddressFactory;
    }

    /**
     * After save observer for customer address attribute
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $attribute = $observer->getEvent()->getAttribute();
        if ($attribute instanceof \Magento\Customer\Model\Attribute && $attribute->isObjectNew()) {
            /** @var $quoteAddress \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\Address */
            $quoteAddress = $this->quoteAddressFactory->create();
            $quoteAddress->saveNewAttribute($attribute);
            /** @var $orderAddress \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\Address */
            $orderAddress = $this->orderAddressFactory->create();
            $orderAddress->saveNewAttribute($attribute);
        }
        return $this;
    }
}
