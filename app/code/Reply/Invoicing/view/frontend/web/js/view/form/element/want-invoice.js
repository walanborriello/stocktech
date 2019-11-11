/**
 * Want Invoice checkbox management
 */
define([
    'Magento_Ui/js/form/element/select'
], function (AbstractField) {
    'use strict';

    return AbstractField.extend({
        defaults: {
            modules: {
                customerInvoiceType: '${ $.parentName }.customer_invoice_type',
                vatId: '${ $.parentName }.vat_id',
                fiscalCodeId: '${ $.parentName }.fiscal_code_id',
                company: '${ $.parentName }.company',
                pec: '${ $.parentName }.pec',
                sdi: '${ $.parentName }.sdi'
            }
        },

        /**
         * Defines if value has changed.
         *
         * @returns {Boolean}
         */
        hasChanged: function () {
            if (this.value()) {
                this.customerInvoiceType().visible(true);
            } else {
                this.customerInvoiceType().visible(false);
                this.vatId().visible(false);
                this.fiscalCodeId().visible(false);
                this.company().visible(false);
                this.pec().visible(false);
                this.sdi().visible(false);
            }

            this._super();
        }
    });
});
