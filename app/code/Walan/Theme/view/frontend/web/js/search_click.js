require(['jquery', 'jquery/ui'], function ($) {
    $(document).ready(function(){
        $('#search-ico').click(function(){
            $('#search_stiky').toggle("slide", {direction:"right"}, 759);
            if ($(window).width() <= 991){
                $(".logo").toggleClass("logo-search-visibility");
            }
            if ($(window).width() <= 500){
                $(this).toggleClass("margin-left-search");
                $(".logo").toggleClass("");
            };

        });
    });
});