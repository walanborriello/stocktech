<?php

namespace Reply\Invoicing\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

/**
 * Class LayoutProcessor
 * @package Reply\Invoicing\Block\Checkout
 */
class LayoutProcessor implements LayoutProcessorInterface
{
    /**
     * Add invoicing fields in billing addresses
     *
     * @param  array $jsLayout
     * @return array
     */
    public function process($jsLayout)
    {
        // billing address form in payment step
        $billingAddressPayment = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
        ['children']['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children'];

        $billingAddressPayment['wantinvoice'] = $this->getWantInvoiceField('billingAddressshared');
        $billingAddressPayment['customer_invoice_type'] = $this->getCustomerInvoiceTypeField('billingAddressshared');
        $billingAddressPayment['pec'] = $this->getPecField('billingAddressshared');
        $billingAddressPayment['sdi'] = $this->getSdiField('billingAddressshared');
        $billingAddressPayment['fiscal_code_id'] = $this->getFiscalCodeField('billingAddressshared');

        $billingAddressPayment['vat_id']['sortOrder'] = 58;
        $billingAddressPayment['vat_id']['visible'] = false;
        $billingAddressPayment['company']['sortOrder'] = 60;
        $billingAddressPayment['company']['visible'] = false;


        return $jsLayout;
    }

    /**
     * Return wantinvoice field
     *
     * @param string $scope
     *
     * @return array
     */
    protected function getWantInvoiceField($scope)
    {
        return [
            'component' => 'Reply_Invoicing/js/view/form/element/want-invoice',
            'config' => [
                'customScope' => $scope . '.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/checkbox'
            ],
            'dataScope' => $scope . '.custom_attributes.wantinvoice',
            'description'   => __('Desidero ricevere la fattura'),
            'provider'  => 'checkoutProvider',
            'sortOrder' => 56,
            'validation'    => [ 'required-entry' => false ],
            'customEntry' => null,
            'visible'   => true,
            'additionalClasses' => 'field-wantinvoice'
        ];
    }

    /**
     * Return customer type choice with radio buttons
     *
     * @param string $scope
     *
     * @return array
     */
    protected function getCustomerInvoiceTypeField($scope)
    {
        return [
            'component' => 'Reply_Invoicing/js/view/form/element/customer-invoice-type',
            'config' => [
                'customScope' => $scope . '.custom_attributes',
                'template' => 'Reply_Invoicing/form/element/customer-invoice-type',
            ],
            'dataScope' => $scope . '.custom_attributes.customer_invoice_type',
            'provider'  => 'checkoutProvider',
            'sortOrder' => 57,
            'validation'    => [ 'required-entry' => false ],
            'customEntry' => null,
            'visible'   => false,
            'additionalClasses' => 'field-customer-invoice-type'
        ];
    }

    /**
     * Return PEC field for the form
     *
     * @param string $scope
     * @return array
     */
    protected function getPecField($scope)
    {
        return [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => $scope,
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => $scope . '.custom_attributes.pec',
            'label' => __('Pec'),
            'provider' => 'checkoutProvider',
            'sortOrder' => 61,
            'validation' => [
                'required-entry' => false,
                'validate-email' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
            'value' => '' // value field is used to set a default value of the attribute
        ];
    }

    /**
     * Return PEC field for the form
     *
     * @param string $scope
     * @return array
     */
    protected function getSdiField($scope)
    {
        return [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => $scope,
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => $scope . '.custom_attributes.sdi',
            'label' => __('Sdi'),
            'provider' => 'checkoutProvider',
            'sortOrder' => 62,
            'validation' => [
                'required-entry' => false
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
            'value' => '' // value field is used to set a default value of the attribute
        ];
    }

    protected function getFiscalCodeField($scope)
    {
        return [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => $scope,
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => $scope . '.custom_attributes.fiscal_code_id',
            'label' => __('Fiscal Code'),
            'provider' => 'checkoutProvider',
            'sortOrder' => 64,
            'validation' => [
                'required-entry' => false
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
            'value' => ''
        ];


    }
}