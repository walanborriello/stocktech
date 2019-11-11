/**
 *
 */
define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var billingAddress = quote.billingAddress();
            console.log(billingAddress);
            if (billingAddress['extension_attributes'] === undefined) {
                billingAddress['extension_attributes'] = {};
            }

            billingAddress['extension_attributes']['wantinvoice'] = billingAddress.customAttributes['wantinvoice'];
            billingAddress['extension_attributes']['fiscal_code_id'] = billingAddress.customAttributes['fiscal_code_id'];
            billingAddress['extension_attributes']['pec'] = billingAddress.customAttributes['pec'];
            billingAddress['extension_attributes']['sdi'] = billingAddress.customAttributes['sdi'];
            // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
            return originalAction();
        });
    };
});
