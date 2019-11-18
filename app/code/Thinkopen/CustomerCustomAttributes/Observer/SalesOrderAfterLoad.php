<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesOrderAfterLoad implements ObserverInterface
{
    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\OrderFactory
     */
    protected $orderFactory;

    /**
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\OrderFactory $orderFactory
     */
    public function __construct(
        \Thinkopen\CustomerCustomAttributes\Model\Sales\OrderFactory $orderFactory
    ) {
        $this->orderFactory = $orderFactory;
    }

    /**
     * After load observer for order
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        if ($order instanceof \Magento\Framework\Model\AbstractModel) {
            /** @var $orderModel \Thinkopen\CustomerCustomAttributes\Model\Sales\Order */
            $orderModel = $this->orderFactory->create();
            $orderModel->load($order->getId());
            $orderModel->attachAttributeData($order);
        }
        return $this;
    }
}
