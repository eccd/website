<?php
/**
 * @version		$Id: view.swipe.php 17 2011-09-28 18:03:12Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'images.php';
class FaceSwipeViewAlbums extends JView
{
	function display($tpl = null) 
	{
		$albumID 	= JRequest::getInt('album_id', 0);
		
		$imageTable = JTable::getInstance('image', 'FaceSwipeTable');
		$albumTable = JTable::getInstance('album', 'FaceSwipeTable');
		
		$albumTable->load($albumID);
		
		$this->album 	= $albumTable;
		$imageClass 	= new comFaceswipeClassesImages;
		$this->images 	= $imageClass->getImagesByALbumID($albumID);
		
		$uri = JURI::base().'components/com_faceswipe/assets/';

		$string = '
		<!DOCTYPE html><html>
		<head>
			<title>PhotoSwipe</title>
			<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
			<meta name="apple-mobile-web-app-capable" content="yes" />
			
			<link href="'.$uri.'js/lib/jquery.mobile-1.0b2/jquery.mobile-1.0b2.min.css" rel="stylesheet" />
			<link href="'.$uri.'css/jquery-mobile.css" type="text/css" rel="stylesheet" />
			<link href="'.$uri.'css/photoswipe.css" type="text/css" rel="stylesheet" />
			<link href="'.$uri.'css/faceswipe.css" type="text/css" rel="stylesheet" />
			
			<script type="text/javascript" src="'.$uri.'js/lib/klass.min.js"></script>
			<script type="text/javascript" src="'.$uri.'js/lib/jquery-1.6.2.min.js"></script>
			<script type="text/javascript" src="'.$uri.'js/lib/jquery.mobile-1.0b2/jquery.mobile-1.0b2.min.js"></script>
			<script type="text/javascript" src="'.$uri.'js/code.photoswipe.jquery-2.0.3.min.js"></script>
			
			<script type="text/javascript">
				(function(window, $, PhotoSwipe){
					
					$(document).ready(function(){
						
						
						$("div.gallery-page").live("pageshow", function(e){
							var 
								currentPage = $(e.target),
								photoSwipeInstanceId = currentPage.attr("id"),
								photoSwipeInstance = PhotoSwipe.getInstance(photoSwipeInstanceId)
								options = {};
							
							if (typeof photoSwipeInstance === "undefined" || photoSwipeInstance === null) {
								photoSwipeInstance = $("ul.gallery a", e.target).photoSwipe(options, photoSwipeInstanceId);
							}
							
							return true;
							
						})
							
					});
				
				}(window, window.jQuery, window.Code.PhotoSwipe));
				
			</script>
			
		</head>
		<body>
		
		<div data-role="page" id="Home">
		
			<div data-role="header">
				<h1>Albums</h1>
			</div>
			
			<div data-role="content" >	
				<ul data-role="listview" data-inset="true">
					<li><a href="#Gallery1">'.$this->album->album_name.'</a></li> 
				</ul> 
			</div>
		</div>
		
		
		<div data-role="page" data-add-back-btn="true" id="Gallery1" class="gallery-page">
		
			<div data-role="header">
				<h1>'.$this->album->album_name.'</h1>
			</div>
		
			<div data-role="content">	
				
				<ul class="gallery">';
				foreach ($this->images as $image){
					$string .= '<li><a href="'.$image->image_source.'" rel="external">
									<img src="'.$image->image_thumbs.'" alt="'.$image->image_title.'" />
								</a></li>';
				}
				
				$string .='</ul>
				
			</div>
		</div>
		</body>
		</html>';
		
		echo $string; jexit();
		
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		parent::display($tpl);
	}
}
