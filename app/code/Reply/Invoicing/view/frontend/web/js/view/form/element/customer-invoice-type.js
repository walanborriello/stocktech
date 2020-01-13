/**
 * Want Invoice checkbox management
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'jquery',
    'ko'
], function (AbstractField, $, ko) {
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

        initialize: function(){
            this._super();
            this.validation = {
                'require-entry' : true,
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
            this.value(value);
            if (value === '1') {
                this.vatId().visible(false);
                this.fiscalCodeId().visible(true);
                this.setValidation(this.fiscalCodeId(), 'required-entry', true);
                this.setValidation(this.pec(), 'required-entry', true);
                $('div[name="' + this.fiscalCodeId().dataScope + '"]').removeClass('second-column-md-6-field').addClass('full-width-field');
                this.company().visible(false);
                this.pec().visible(true);
                this.sdi().visible(true);
                this.sdi().value('0000000');
                this.pec().value('');
                this.company().value('');
                this.setValidation(this.vatId(), 'required-entry', false);
                this.setValidation(this.company(), 'required-entry', false);
            } else if (value === '2') {
                this.vatId().visible(true);
                this.fiscalCodeId().visible(true);
                this.setValidation(this.pec(), 'required-entry', false);
                this.setValidation(this.fiscalCodeId(), 'required-entry', false);
                this.setValidation(this.company(), 'required-entry', true);
                this.setValidation(this.vatId(), 'required-entry', true);
                this.fiscalCodeId().value('');
                $('div[name="' + this.fiscalCodeId().dataScope + '"]').removeClass('full-width-field').addClass('second-column-md-6-field');
                this.company().visible(true);
                this.sdi().value('');
                this.pec().visible(true);
                this.pec().value('');
                this.sdi().visible(true);
            }
        },

        setValidation: function(Component, field, value){
            if(!typeof Component.validation === "object"){
                Component.validation = {};
            }

            Component.validation[field] = value;
        },

        validate: function () {

        }
    });
});
