<?php

namespace Walan\Theme\Block\Html;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Backend\Block\Template\Context;

class Hello extends \Magento\Framework\View\Element\Template
{

    protected $_session;
    protected $_customer;

    protected $_context;

    public function __construct(
        Customer $customer,
        Session $session,
        Context $context
    ) {
        parent::__construct($context);
        $this->_customer = $customer;
        $this->_session = $session;
    }

    /**
     * Get Customer Data by ID customer
     *
     * @return array
     */

    public function getCustomerData(){
        $customerId = $this->_session->getCustomer()->getId();

        $customer = $this->_customer->load($customerId);

        $customerData = [];

        // if customer is logged
        if($customerId){
            $customerData = [
                'firstName' => $customer->getFirstname(),
                'lastName' => $customer->getLastname()
            ];
        }


        return $customerData;
    }

    public function getCustomerId(){
        return $this->_session->getCustomer()->getId();
    }
}