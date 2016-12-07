jQuery(function ($){
	var mobileMenu = $(".navbar-main-primary-toggle");
	var root = $("html");
    var body = $("body");
	var homeAnimated = false;
    
	$(document).on("ready", function(){
		if (Modernizr.mq('(min-width: 992px)')) {
			animateHome();	
		}
		
		var waypoints = $('#recent-projects').waypoint({			
			handler: function(direction) {
				animatePortfolioItems();
		  	},
		  	offset: 400
		});
		
		$('.navbar-nav').find('a').on('click', function(e){			
			if($(this).parent().hasClass("menu-item-has-children")){
				$(".dropdown-menu").toggleClass("active");
			}        
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
            if(!homeAnimated){animateHome();}            
		}
	});	
	
	function animateHome() {
		var name = $(".navbar-brand"),
			jobTitle = $(".job-title"),
			links = $(".navbar-nav li"),
			heroHeading = $(".hero-heading"),
			heroCopy = $(".hero-copy"),
            heroCopyStr = $(".hero-copy").text(),
            heroCopyAry = [],
            heroCopyAryMarkup = [],
            copyAryMarkup = $(".hero-copy-ary"),
			arrowContainer = $(".arrow-container"),
			delay = 1000,
            tl = new TimelineMax();
        
        heroCopyAry = heroCopyStr.split(" ");
        
        for(var i = 0; i < heroCopyAry.length; i++){
            var tt = "";
            tt+= "<div class='hero-copy-ary-item'>"+heroCopyAry[i]+"</div>";
            heroCopyAryMarkup.push(tt);
        }
        
		copyAryMarkup.html(heroCopyAryMarkup);
		 tl.add( TweenLite.to(name, 0.8, {marginTop: 10,opacity: 1,ease: Back.easeInOut}) )
            .to(jobTitle, 2, {opacity: 1,ease: Back.easeInOut},"-=.5" )
            .staggerTo(links, 0.4, {marginTop: 0, ease: Back.easeInOut}, 0.2,"-=1.8")
            .fromTo(heroHeading, 1, {scaleX: 0, scaleY: 0, opacity: 0},{scaleX: 1, scaleY: 1, opacity: 1, ease: Back.easeInOut}, "-=3")
            .staggerFromTo($(".hero-copy-ary div"), 0.75, {opacity: 0, top:80, rotation: 180},{opacity: 1, top:10, rotation:0, ease: Back.easeInOut},0.15,"-=2.5")
            .to(arrowContainer, 3, {opacity: 1});
		
        
        homeAnimated = true;
	}
    
    function animatePortfolioItems() {
        var itemContainer = $(".item-logo-container"),
            delay = 0;
        
        itemContainer.each(function(){			
			$(this).delay(delay).animate({opacity: 1},600);	
			delay += 200;
		});        
    }
});
