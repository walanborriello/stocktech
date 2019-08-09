/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'jquery/ui',
    'bootstrap'
], function ($) {
    'use strict';
    $.widget('stocktech.popover', {
        options:{
            toggle:"[data-toggle=popover]"
        },
        _create: function(config,element) {
            $(element).popover();
        }
    });

    return $.walan.stocktech;
});
