$(document).on("ready",function(){
	var mobileMenu = $(".navbar-collapse"),		
		sideslider = $('[data-toggle=collapse-side]'),
		body = $("body");
		sel = sideslider.attr('data-target');
	
	sideslider.click(function(event) {
		$(this).toggleClass("close-menu");
		$(sel).toggleClass('in');
		body.toggleClass("disable-scrolling");
	});
	
	$('.grid').masonry({
		itemSelector: '.grid-item',
		columnWidth: 325,
		gutter: 10,
		isFitWidth: true
	});
});