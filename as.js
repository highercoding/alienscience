/*
 * AlienScience JS
 */
jQuery(document).ready(function() {
	
	/* Homepage slider */
    jQuery('#slider').bxSlider({
		pager: true,
    	captions: true
	});
	
	/* Slider icon animation */
	jQuery(".slide-image").hover(function(){
		jQuery(this).find(".fa").animate({
			width: "148px",
			height: "148px",
			fontSize: "148px",
			padding: "-=10px"
		}, 300);
	}, function() {
		jQuery(this).find(".fa").animate({
			width: "128px",
			height: "128px",
			fontSize: "128px",
			padding: "+=10px"
		}, 120);
	});
	
	/* Header icon animation */
	jQuery(".header-button").hover(function(){
		jQuery(this).find(".button-icon").animate({
			width: "64px",
			height: "64px",
			marginTop: "-=40px"
		}, 300);
		jQuery(this).find(".button-fa").animate({
			width: "64px",
			height: "64px",
			fontSize: "64px",
			marginTop: "-=40px"
		}, 300);
		jQuery(this).find(".button-text").animate({
			opacity: "0",
			marginTop: "+=16px"
		}, 300);
	}, function() {
		jQuery(this).find(".button-icon").animate({
			width: "32px",
			height: "32px",
			marginTop: "+=40px"
		}, 120);
		jQuery(this).find(".button-fa").animate({
			width: "32px",
			height: "32px",
			fontSize: "32px",
			marginTop: "+=40px"
		}, 120);
		jQuery(this).find(".button-text").animate({
			opacity: "1",
			marginTop: "-=16px"
		}, 120);
	});
	
	/* Bullet point animation (requires background animation plugin) */
	jQuery(".widget ul li a").hover(function(){
		jQuery(this).animate({
			backgroundPosition: "(7px 7px)"
		}, 80);
	}, function() {
		jQuery(this).animate({
			backgroundPosition: "(-5px 7px)"
		}, 240);
	});
	
	/* Sidebar scrolling */
	var $sidebar = jQuery("#secondary"),
        $window = jQuery(window),
		$height = parseInt(jQuery("#footer").css("height")) + parseInt(jQuery(".footer-widgets").css("height")),
		$area = parseInt(jQuery(document).height()),
        offset = $sidebar.offset(),
        topPadding = 20;

    $window.scroll(function() {
		$area = parseInt(jQuery(document).height());
		if(($window.height() > parseInt($sidebar.css("height")))
			&& (300 < ($area - $height - parseInt($sidebar.css("height"))))) {
		if($window.scrollTop() > ($area - $height - 160 - parseInt($sidebar.css("height")))) {
            $sidebar.css("position", "relative");
            $sidebar.css("left", 0);
            $sidebar.css("top", ($area - $height - 140 - parseInt($sidebar.css("height")) - offset.top));
		} else if(($window.scrollTop() + topPadding) > offset.top) {
            $sidebar.css("position", "fixed");
            $sidebar.css("left", offset.left);
            $sidebar.css("top", topPadding);
        } else {
            $sidebar.css("position", "relative");
            $sidebar.css("left", 0);
            $sidebar.css("top", 0);
        }
		}
    });
	
	/* Responsive menu */
	jQuery('#access').prepend('<div id="menu-button"><i class="fa fa-bars"></i>Menu</div>');
	jQuery('#access #menu-button').on('click', function(){
    	var menu = jQuery('#access').find('div');
		if(menu.hasClass('open')) {
			menu.removeClass('open');
			jQuery(this).removeClass('opened');
		} else {
			menu.addClass('open');
			jQuery(this).addClass('opened');
		}
	});
	
	/* Flash hacks */
	var src;
	jQuery("iframe").each(function(){
		src = jQuery(this).attr("src");
		jQuery(this).attr("src", src+"?wmode=opaque");
	});
	
	/* Plugin hacks */
	jQuery(".remove_button").attr("value", "Remove");
});
