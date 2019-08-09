/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'jquery/ui',
    'bootstrap',
    'jquery/jquery-storageapi'
], function ($) {
    'use strict';

    var stocktech = {
        init: function () {
            this.footerOpenStores();
        },

        closeMessages: function () {

        },

        footerOpenStores: function () {
            $("#bm_shop .stores__title").on("click", function (e) {
                e.preventDefault();

                $("#bm_shop").toggleClass('stores--open');
                $("#bm_div-shop").toggleClass("list-stores--open");
            });
        }

    };


    $(document).ready(function ($) {

        $(".message__icon-close .bm-icon-delete").live("click", function (e) {
            e.preventDefault();

            var that = $(this);

            var idMessage = that.data('ui-id');
            $('.row[data-ui-id="' + idMessage + '"]').remove();

            // remove messages from cookie
            $.cookieStorage.set('mage-messages', '');
        });

        stocktech.init();

    });
});
