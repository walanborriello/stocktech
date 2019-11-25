define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setBillingAddressAction) {
        return wrapper.wrap(setBillingAddressAction, function (originalAction, messageContainer) {
            console.log("d");

            var billingAddress = quote.billingAddress();

            console.log(billingAddress);
            if (billingAddress != undefined) {

                if (billingAddress['extension_attributes'] === undefined) {
                    billingAddress['extension_attributes'] = {};
                }

                if (billingAddress.customAttributes != undefined) {
                    $.each(billingAddress.customAttributes, function (key, value) {
                        if ($.isPlainObject(value)) {
                            key = value['attribute_code'];
                            value = value['value'];
                        }

                        if (key !== 'customer_invoice_type') {
                            billingAddress['extension_attributes'][key] = value;
                            if(key === 'wantinvoice'){
                                billingAddress['extension_attributes'][key] = parseInt(value);
                            }
                        }
                    });
                }

            }

            return originalAction(messageContainer);
        });
    };
});