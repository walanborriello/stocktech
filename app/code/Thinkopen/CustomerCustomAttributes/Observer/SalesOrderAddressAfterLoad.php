<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesOrderAddressAfterLoad implements ObserverInterface
{
    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\AddressFactory
     */
    protected $orderAddressFactory;

    /**
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\AddressFactory $orderAddressFactory
     */
    public function __construct(
        \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\AddressFactory $orderAddressFactory
    ) {
        $this->orderAddressFactory = $orderAddressFactory;
    }

    /**
     * After load observer for order address
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $address = $observer->getEvent()->getAddress();
        if ($address instanceof \Magento\Framework\Model\AbstractModel) {
            /** @var $orderAddress \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\Address */
            $orderAddress = $this->orderAddressFactory->create();
            $orderAddress->attachDataToEntities([$address]);
        }
        return $this;
    }
}
