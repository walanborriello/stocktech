define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setBillingAddressAction) {
        return wrapper.wrap(setBillingAddressAction, function (originalAction, messageContainer) {
            console.log("b");

            var billingAddress = quote.billingAddress();

            if (billingAddress != undefined) {

                if (billingAddress['extension_attributes'] === undefined) {
                    billingAddress['extension_attributes'] = {};
                }

                if (billingAddress.customAttributes != undefined) {
                    console.log(billingAddress.customAttributes);
                    $.each(billingAddress.customAttributes, function (key, value) {

                        if ($.isPlainObject(value)) {
                            key = value['attribute_code'];
                            value = value['value'];

                        }
                        console.log(key + '  ' + value);
                        billingAddress['extension_attributes'][key] = value;
                    });
                    billingAddress['extension_attributes']['wantinvoice'] = "1";
                }

            }
            return originalAction();
        });
    };
})