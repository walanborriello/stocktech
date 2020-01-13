<?php

namespace Thinkopen\CustomAttributeManagement\Override;

use Magento\Quote\Model\QuoteAddressValidator;
use Psr\Log\LoggerInterface as Logger;
use Magento\Framework\Exception\InputException;
use Magento\Quote\Model\Quote\Address\BillingAddressPersister;
use Magento\Quote\Api\BillingAddressManagementInterface;
use Magento\Framework\App\ObjectManager;

class BillingAddressManagement extends \Magento\Quote\Model\BillingAddressManagement{

    protected $addressValidator;

    /**
     * Logger.
     *
     * @var Logger
     */
    protected $logger;

    /**
     * Quote repository.
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var \Magento\Customer\Api\AddressRepositoryInterface
     */
    protected $addressRepository;

    /**
     * @var \Magento\Quote\Model\ShippingAddressAssignment
     */
    private $shippingAddressAssignment;

    public function __construct(\Magento\Quote\Api\CartRepositoryInterface $quoteRepository, QuoteAddressValidator $addressValidator, Logger $logger, \Magento\Customer\Api\AddressRepositoryInterface $addressRepository){
        parent::__construct($quoteRepository, $addressValidator, $logger, $addressRepository);
    }

    public function assign($cartId, \Magento\Quote\Api\Data\AddressInterface $address, $useForShipping = false){
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        $address->setCustomerId($quote->getCustomerId());
        $quote->removeAddress($quote->getBillingAddress()->getId());
        $quote->setBillingAddress($address);
        if($address->getExtensionAttributes()){
            $quote->getBillingAddress()->setData('wantinvoice', $address->getExtensionAttributes()->getWantinvoice());
        }
        if($address->getExtensionAttributes()){
            $quote->getBillingAddress()->setData('customer_invoice_type', $address->getExtensionAttributes()->getCustomerInvoiceType());
        }
        try{
            $this->getShippingAddressAssignment()->setAddress($quote, $address, $useForShipping);
            $quote->setDataChanges(true);
            $this->quoteRepository->save($quote);
        }catch(\Exception $e){
            $this->logger->critical($e);
            throw new InputException(__('The address failed to save. Verify the address and try again.'));
        }
        return $quote->getBillingAddress()->getId();
    }

    /**
     * @inheritdoc
     */
    public function get($cartId){
        $cart = $this->quoteRepository->getActive($cartId);
        return $cart->getBillingAddress();
    }

    /**
     * Get shipping address assignment
     *
     * @return \Magento\Quote\Model\ShippingAddressAssignment
     * @deprecated 101.0.0
     */
    private function getShippingAddressAssignment(){
        if(!$this->shippingAddressAssignment){
            $this->shippingAddressAssignment = ObjectManager::getInstance()
                ->get(\Magento\Quote\Model\ShippingAddressAssignment::class);
        }
        return $this->shippingAddressAssignment;
    }

}