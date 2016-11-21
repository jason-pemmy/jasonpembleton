jQuery(function ($){
	var mobileMenu = $(".navbar-main-primary-toggle");
	var root = $("html");
    var body = $("body");
    
	mobileMenu.on("click",function(){
		root.toggleClass("mobile-menu-open");	
        body.toggleClass("disable-scrolling");
        
	});
	
	$(window).resize(function() {
		if (Modernizr.mq('(min-width: 992px)')) {
			if(root.hasClass("mobile-menu-open")){
				root.removeClass("mobile-menu-open");
                body.removeClass("disable-scrolling");
			}
		}
	});	
});
