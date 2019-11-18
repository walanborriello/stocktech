define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction, messageContainer) {
            console.log("a");
            if (messageContainer.custom_attributes != undefined) {
                $.each(messageContainer.custom_attributes , function( key, value ) {
                    if(key !== 'customer_invoice_type') {
                        messageContainer['custom_attributes'][key] = {'attribute_code': key, 'value': value};
                    }
                });
            }

            return originalAction(messageContainer);
        });
    };
});