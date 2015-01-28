<?php

// include zend loader
$root = realpath(dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"])))))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( WP_PLUGIN_DIR . '/sliding-youtube-gallery/engine/SygPlugin.php');

$syg = SygPlugin::getInstance();
$option = $syg->getGallerySettings($_GET['id']);
extract ($option);

// set http header
header('Content-type: text/javascript; charset=utf-8');
header('Expires: '.gmdate("D, d M Y H:i:s", time() + 3600*24*365).' GMT');
?>
jQuery.noConflict();
(function($) {
$(window).load(function() {
	if (window.console) console.log('gallery loading function >> start');
	
	$('#syg_video_gallery-<?php echo $id; ?>').removeClass('syg_video_gallery_loading-<?php echo $id; ?>');
	/* $('#syg_video_gallery-<?php echo $id; ?>').addClass('syg_video_gallery-<?php echo $id; ?>'); */
	
	
	/* remove display none */
	$('.sc_menu-<?php echo $id;?>').removeAttr('style');

	$(function($){
		// Get our elements for faster access and set overlay width
		var div = $('div.sc_menu-<?php echo $id; ?>'),
			ul = $('ul.sc_menu-<?php echo $id; ?>'),
			ulPadding = 15;
		
		//Get menu width
		var divWidth = <?php echo $syg_box_width; ?>;
				
		//Remove scrollbars	
		div.css({overflow: 'hidden'});
		
		//Find last image container
		var lastLi = ul.find('li:last-child');
		
		if ($.fn.sygclient('isMobileBrowser', this)) {
			div.bind('touchmove', function($Event) {
				$Event.preventDefault();
			   	//As images are loaded ul width increases,
				//so we recalculate it each time
				var event = window.event;
				var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;	
				var left = (event.touches[0].pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
				div.scrollLeft(left);
			});
		} else {
			//When user move mouse over menu
			div.mousemove(function(e){
				//As images are loaded ul width increases,
				//so we recalculate it each time
				
				var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;	
				var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
				div.scrollLeft(left);
			});
		}
	});
	
	if ($.fn.sygclient('isMobileBrowser')) {
		$.mobile.hidePageLoadingMsg();
	}
	
	if (window.console) console.log('gallery loading function >> end');
});})(jQuery);