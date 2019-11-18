/**
 * Want Invoice checkbox management
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'jquery'
], function (AbstractField, $) {
    'use strict';

    return AbstractField.extend({
        defaults: {
            modules: {
                vatId: '${ $.parentName }.vat_id',
                fiscalCodeId: '${ $.parentName }.fiscal_code_id',
                company: '${ $.parentName }.company',
                pec: '${ $.parentName }.pec',
                sdi: '${ $.parentName }.sdi'
            }
        },

        /**
         * Handle radio click, return true to check te radio
         */
        click: function(data, event) {
            this.change(event.target.value);
            return true;
        },

        /**
         * Change value of radio
         */
        change: function(value) {
            if (value === '1') {
                this.vatId().visible(false);
                this.fiscalCodeId().visible(true);
                this.fiscalCodeId().required(true);
                $('div[name="' + this.fiscalCodeId().dataScope + '"]').removeClass('second-column-md-6-field').addClass('full-width-field');
                this.company().visible(false);
                this.company().required(false);
                this.pec().visible(true);
                this.sdi().visible(true);
                this.sdi().value('0000000');
                this.pec().value('');
                this.company().value('');
            } else if (value === '2') {
                this.vatId().visible(true);
                this.fiscalCodeId().visible(true);
                this.fiscalCodeId().required(false);
                this.fiscalCodeId().value('');
                $('div[name="' + this.fiscalCodeId().dataScope + '"]').removeClass('full-width-field').addClass('second-column-md-6-field');
                this.company().visible(true);
                this.company().required(true);
                this.sdi().value('');
                this.pec().visible(true);
                this.pec().value('');
                this.pec().required(true);
                this.sdi().visible(true);
            }
        }
    });
});
