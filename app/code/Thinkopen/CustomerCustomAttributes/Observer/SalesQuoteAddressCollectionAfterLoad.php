<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesQuoteAddressCollectionAfterLoad implements ObserverInterface
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
     * After load observer for collection of quote address
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $collection = $observer->getEvent()->getQuoteAddressCollection();
        if ($collection instanceof \Magento\Framework\Data\Collection\AbstractDb) {
            /** @var $quoteAddress \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote\Address */
            $quoteAddress = $this->quoteAddressFactory->create();
            $quoteAddress->attachDataToEntities($collection->getItems());
        }
        return $this;
    }
}
