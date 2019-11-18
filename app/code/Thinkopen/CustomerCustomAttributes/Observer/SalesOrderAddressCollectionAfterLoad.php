<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesOrderAddressCollectionAfterLoad implements ObserverInterface
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
     * After load observer for collection of order address
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $collection = $observer->getEvent()->getOrderAddressCollection();
        if ($collection instanceof \Magento\Framework\Data\Collection\AbstractDb) {
            /** @var $orderAddress \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\Address */
            $orderAddress = $this->orderAddressFactory->create();
            $orderAddress->attachDataToEntities($collection->getItems());
        }
        return $this;
    }
}
