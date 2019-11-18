define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction, messageContainer) {
            console.log("c");

            var shippingAddress = quote.shippingAddress();

            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            if (shippingAddress.customAttributes != undefined) {
                $.each(shippingAddress.customAttributes, function (key, value) {
                    if ($.isPlainObject(value)) {
                        key = value['attribute_code'];
                        value = value['value'];
                    }
                    if (key !== 'customer_invoice_type') {
                        shippingAddress['customAttributes'][key] = value;
                        shippingAddress['extension_attributes'][key] = value;
                        if(key === 'wantinvoice'){
                            shippingAddress['extension_attributes'][key] = parseInt(value);
                        }
                    }
                });
            }

            return originalAction(messageContainer);
        });
    };
});