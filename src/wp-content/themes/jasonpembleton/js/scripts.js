jQuery(function ($){
	var mobileMenu = $(".navbar-main-primary-toggle");
	var root = $("html");
    var body = $("body");
	
	$(document).on("ready", function(){
		if (Modernizr.mq('(min-width: 992px)')) {
			animateHome();	
		}
		
		/*var waypoints = $('#recent-projects').waypoint({
			handler: function(direction) {
				console.log("hit");				
			}
		},{offset:"50%"});		*/
		
		var waypoints = $('#recent-projects').waypoint({			
			handler: function(direction) {
				console.log('400px from top');
		  	},
		  	offset: 400
		});
	});
    
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
	
	function animateHome() {
		var name = $(".navbar-brand"),
			jobTitle = $(".job-title"),
			links = $(".navbar-nav li"),
			heroHeading = $(".hero-heading"),
			heroCopy = $(".hero-copy"),
			arrowContainer = $(".arrow-container"),
			delay = 1000;		
		
		name.addClass("animate");
		jobTitle.addClass("animate");
		
		links.each(function(){			
			$(this).delay(delay).animate({marginTop: 0},400);	
			delay += 300;
		});		
		
		heroHeading.addClass("animate");
		heroCopy.addClass("animate");
		arrowContainer.addClass("animate");
	}
});
