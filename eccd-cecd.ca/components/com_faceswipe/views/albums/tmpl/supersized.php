<?php
/**
 * @version		$Id: supersized.php 9 2011-09-27 17:58:21Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

	$images = array();
	foreach ($this->images as $image)
	{
		$data = new stdClass();
		$data->image = $image->image_source;
		$data->title = $image->image_title;
		$data->thumb = $image->image_thumbs;
		$data->url 	 = $image->image_link;
		$images[] = $data;
	}
	$images = json_encode($images);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!--
		Supersized - Fullscreen Slideshow jQuery Plugin
		Version : 3.2.4
		Site	: www.buildinternet.com/project/supersized
		
		Author	: Sam Dunn
		Company : One Mighty Roar (www.onemightyroar.com)
		License : MIT License / GPL License
	-->
	
	<head>

		<title><?php $this->albumTable->album_name; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		
		<link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_faceswipe/assets/css/supersized/css/supersized.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_faceswipe/assets/css/supersized/css/supersized.shutter.css" type="text/css" media="screen" />
		
		<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_faceswipe/assets/js/lib/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_faceswipe/assets/js/lib/jquery.easing.min.js"></script>
		
		<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_faceswipe/assets/js/supersized/supersized.3.2.4.min.js"></script>
		<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_faceswipe/assets/js/supersized/supersized.shutter.min.js"></script>
		
		<script type="text/javascript">
		
		jQuery(function($){
			$.supersized.themeVars.image_path = "<?php echo JURI::base(); ?>components/com_faceswipe/assets/css/supersized/img/";
			$.supersized({
			
				// Functionality
				slideshow               :   1,			// Slideshow on/off
				autoplay				:	1,			// Slideshow starts playing automatically
				start_slide             :   1,			// Start slide (0 is random)
				stop_loop				:	0,			// Pauses slideshow on last slide
				random					: 	0,			// Randomize slide order (Ignores start slide)
				slide_interval          :   3000,		// Length between transitions
				transition              :   <?php echo rand(0, 7); ?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
				transition_speed		:	1000,		// Speed of transition
				new_window				:	1,			// Image links open in new window/tab
				pause_hover             :   1,			// Pause slideshow on hover
				keyboard_nav            :   1,			// Keyboard navigation on/off
				performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
				image_protect			:	1,			// Disables image dragging and right click with Javascript
														   
				// Size & Position						   
				min_width		        :   0,			// Min width allowed (in pixels)
				min_height		        :   0,			// Min height allowed (in pixels)
				vertical_center         :   1,			// Vertically center background
				horizontal_center       :   1,			// Horizontally center background
				fit_always				:	1,			// Image will never exceed browser width or height (Ignores min. dimensions)
				fit_portrait         	:   1,			// Portrait images will not exceed browser height
				fit_landscape			:   1,			// Landscape images will not exceed browser width
														   
				// Components							
				slide_links				:	'blank',	// Individual links for each slide (Options: false, 'number', 'name', 'blank')
				thumb_links				:	1,			// Individual thumb links for each slide
				thumbnail_navigation    :   1,			// Thumbnail navigation
				slides 					:  	<?php echo $images; ?>,
											
				// Theme Options			   
				progress_bar			:	1,			// Timer for each slide							
				mouse_scrub				:	0
				   
			});
	    });
		    
		</script>
		
	</head>

<body>

	<!--Thumbnail Navigation-->
	<div id="prevthumb"></div>
	<div id="nextthumb"></div>
	
	<!--Arrow Navigation-->
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>
	
	<div id="thumb-tray" class="load-item">
		<div id="thumb-back"></div>
		<div id="thumb-forward"></div>
	</div>
	
	<!--Time Bar-->
	<div id="progress-back" class="load-item">
		<div id="progress-bar"></div>
	</div>
	
	<!--Control Bar-->
	<div id="controls-wrapper" class="load-item">
		<div id="controls">
			
			<a id="play-button"><img id="pauseplay" src="<?php echo JURI::base(); ?>components/com_faceswipe/assets/css/supersized/img/pause.png"/></a>
		
			<!--Slide counter-->
			<div id="slidecounter">
				<span class="slidenumber"></span> / <span class="totalslides"></span>
			</div>
			
			<!--Slide captions displayed here-->
			<div id="slidecaption"></div>
			
			<!--Thumb Tray button-->
			<a id="tray-button"><img id="tray-arrow" src="<?php echo JURI::base(); ?>components/com_faceswipe/assets/css/supersized/img/button-tray-up.png"/></a>
			
			<!--Navigation-->
			<ul id="slide-list"></ul>
			
		</div>
	</div>

</body>
</html>
