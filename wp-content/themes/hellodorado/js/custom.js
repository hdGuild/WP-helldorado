(function($){
$(document).ready(function(){
    $('.right-sidebar').height($('.left-section').height());
    $('.left-border').height($('.banner-section').height() + 50);
    $('.right-border').height($('.banner-section').height() + 50);
     $(window).resize(function(){
        $('.right-sidebar').height($('.left-section').height());
        $('.left-border').height($('.banner-section').height() + 50);
        $('.right-border').height($('.banner-section').height() + 120);
    });
    $(".back-to-top").click(function () {
	   $("html, body").animate({scrollTop: 0}, 1000);
	}); 
});
 
jQuery('nav#menu').mmenu();
 
})(jQuery);