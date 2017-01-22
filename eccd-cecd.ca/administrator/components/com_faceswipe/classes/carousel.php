<?php
/**
 * @version		$Id: carousel.php 9 2011-09-27 17:58:21Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'classes'.DS.'default.php';
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'classes'.DS.'images.php';
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'classes'.DS.'facebook.php';
class comFaceswipeClassesCarousel extends comFaceswipeClassesDefault
{
	function renderGallery($albumID)
	{
		$imageClass = new comFaceswipeClassesImages;
		$images 	= $imageClass->getImagesByALbumID($albumID);
		$rand 	 	= $imageClass->genRandomString();
		$albumTable = JTable::getInstance('album', 'faceswipetable');
		
		$html ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
		<head>
		<link href="'.JURI::base().'components/com_faceswipe/assets/css/carousel/carousel.css" type="text/css" rel="stylesheet" />
		<link href="'.JURI::base().'components/com_faceswipe/assets/css/colorbox/colorbox.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="'.JURI::base().'components/com_faceswipe/assets/js/lib/jquery-1.6.2.min.js"></script>
		<script type="text/JavaScript" src="'.JURI::base().'components/com_faceswipe/assets/js/lib/jquery.mousewheel/jquery.mousewheel.js"></script>
		<script type="text/JavaScript" src="'.JURI::base().'components/com_faceswipe/assets/js/carousel/cloud-carousel.1.0.5.js"></script>
		<script type="text/JavaScript" src="'.JURI::base().'components/com_faceswipe/assets/js/colorbox/jquery.colorbox.js"></script>
		 
		<script>
		$(document).ready(function(){
			var heightCarousel = $("#carousel").height() / 3;
			// This initialises carousels on the container elements specified, in this case, carousel1.
			$("#carousel").CloudCarousel(		
				{			
					xPos: 500,
					yPos: heightCarousel,
					yRadius: 40,
					reflHeight: 30,
					reflGap: 2,
					reflOpacity: 0.3,
					mouseWheel: true,
					altBox: $("#title"),
					titleBox: $("#description")
				}
			);
			
			$("a[rel=\"lightbox\"]").colorbox();
			
		});
		 
		</script>
		 
		</head>
		    <body>
		    	<div id="container">
			    	<div id="top">
			    		 <p id="title">test test</p>
			        </div>
			    	<div id="carousel">';
						foreach ($images as $image)
						{
							$html .= '<a href="'.$image->image_source.'" rel="lightbox">
							<img class="cloudcarousel" src="'.$image->image_thumbs.'" alt='.$this->_db->quote($image->image_description).' title='.$this->_db->quote($image->image_title).' /></a>';
						}
			$html .='
					</div>
			        <div id="bottom"><p id="description">test test</p></div>
			    </div>
		        
		    </body>
		</html>';
		
		
		
		return $html;
	}
}