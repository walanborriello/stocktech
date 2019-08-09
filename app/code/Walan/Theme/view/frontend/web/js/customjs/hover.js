define([
    'jquery',
    'jquery/ui',
    'bootstrap'
], function ($) {
    'use strict';

    $(document).ready(function ($) {
        $(".nav-sections nav.navigation .bottom__first").hover(
            function() {
                $(this).addClass("bottom__first--show-menu");
                $("body").addClass("bm_overflow");
            }, function() {
                $(this).removeClass("bottom__first--show-menu");
                $("body").removeClass("bm_overflow");
            }
        );

        /* Popup area personale */
        $("header .header.content .top__right .info__title").on("click" , function(){
            var father = $(this).closest("li.customer-welcome");

            if($(father).hasClass("active")){
                bodyOverflow(true);
            }else{
                bodyOverflow(false);
            }

        });

        /* Popup minicart */
        $("header .header.content .top__right .minicart-wrapper .bm-icon-icon-cart-header").on("click" , function(){
            var father = $(this).closest(".minicart-wrapper");

            if($(father).hasClass("active")){
                bodyOverflow(true);
            }else{
                bodyOverflow(false);
            }

        });

    });

    function bodyOverflow(flag){
        if(flag){
            $("body").addClass("bm_overflow");
        }else{
            $("body").removeClass("bm_overflow");
        }
    }

    
});