<?php


namespace Reply\Invoicing\Plugin;

class BillingAddressManagement{

    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ){
        $this->logger = $logger;
    }

    public function beforeAssign(
        \Magento\Quote\Model\BillingAddressManagement $subject,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address,
        $useForShipping = false
    ){
        $this->logger->error('LA PUTTANA DI MAMMETA');
        $extAttributes = $address->getExtensionAttributes();
        if(!empty($extAttributes)){
            try{
                $address->setWantinvoice($extAttributes->getWantinvoice());
                $address->setFiscalCodeId($extAttributes->getFiscalCodeId());
                $address->setPec($extAttributes->getPec());
                $address->setSdi($extAttributes->getSdi());
                $address->setCustomerInvoiceType($extAttributes->getCustomerInvoiceType());
            }catch(\Exception $e){
                $this->logger->critical($e->getMessage());
            }

        }

    }
}