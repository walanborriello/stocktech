<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
namespace Thinkopen\CustomerCustomAttributes\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesQuoteAfterLoad implements ObserverInterface
{
    /**
     * @var \Thinkopen\CustomerCustomAttributes\Model\Sales\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @param \Thinkopen\CustomerCustomAttributes\Model\Sales\QuoteFactory $quoteFactory
     */
    public function __construct(
        \Thinkopen\CustomerCustomAttributes\Model\Sales\QuoteFactory $quoteFactory
    ) {
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * After load observer for quote
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        if ($quote instanceof \Magento\Framework\Model\AbstractModel) {
            /** @var $quoteModel \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote */
            $quoteModel = $this->quoteFactory->create();
            $quoteModel->load($quote->getId());
            $quoteModel->attachAttributeData($quote);
        }
        return $this;
    }
}
