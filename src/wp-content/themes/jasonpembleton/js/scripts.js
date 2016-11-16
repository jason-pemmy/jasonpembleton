jQuery(function ($){
	var mobileMenu = $(".navbar-main-primary-toggle");
	
	mobileMenu.on("click",function(){
		$("html").toggleClass("mobile-menu-open");		
	});
	
	$(window).resize(function() {
		if (Modernizr.mq('(min-width: 992px)')) {
			if($("html").hasClass("mobile-menu-open")){
				$("html").removeClass("mobile-menu-open");
			}
		}
	});	
});
