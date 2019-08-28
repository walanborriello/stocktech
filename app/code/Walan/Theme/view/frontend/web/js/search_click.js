require(['jquery', 'jquery/ui'], function ($) {
    $(document).ready(function(){
        $('#search-ico').click(function(){
            $('#search_stiky').toggle("slide", {direction:"right"}, 1000);
        });
    });
});