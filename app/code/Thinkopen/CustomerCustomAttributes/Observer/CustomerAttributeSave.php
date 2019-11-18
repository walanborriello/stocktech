<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomerAttributeSave implements ObserverInterface
{
    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\OrderFactory
     */
    protected $orderFactory;

    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\OrderFactory $orderFactory
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\QuoteFactory $quoteFactory
     */
    public function __construct(
        \Thinkopen\CustomerCustomAttributes\Model\Sales\OrderFactory $orderFactory,
        \Thinkopen\CustomerCustomAttributes\Model\Sales\QuoteFactory $quoteFactory
    ) {
        $this->orderFactory = $orderFactory;
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * After save observer for customer attribute
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $attribute = $observer->getEvent()->getAttribute();
        if ($attribute instanceof \Magento\Customer\Model\Attribute && $attribute->isObjectNew()) {
            /** @var $quoteModel \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote */
            $quoteModel = $this->quoteFactory->create();
            $quoteModel->saveNewAttribute($attribute);
            /** @var $orderModel \Thinkopen\CustomerCustomAttributes\Model\Sales\Order */
            $orderModel = $this->orderFactory->create();
            $orderModel->saveNewAttribute($attribute);
        }
        return $this;
    }
}
