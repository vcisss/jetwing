jQuery(function($) {
    var slide = true;
    var height = $('#bar-bawah').height();
    $('#bar-bawah-button').click(function() {
        var docHeight = $(document).height();
        var windowHeight = $(window).height();
        var scrollPos = docHeight - windowHeight + height;
        $('#bar-bawah').animate({ height: "toggle"}, 1000);
        if(slide == false) {
            if($.browser.opera) { //Fix opera double scroll bug by targeting only HTML.
                $('html').animate({scrollTop: scrollPos+'px'}, 1000);
            } else {
                $('html, body').animate({scrollTop: scrollPos+'px'}, 1000);
            }
                            slide = true;
        } else {
                            slide = false;
                    }
    });
});