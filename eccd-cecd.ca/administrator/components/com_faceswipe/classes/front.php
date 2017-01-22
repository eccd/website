<?php
/**
 * @version		$Id: front.php 57 2012-01-05 15:18:55Z trung $
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
class comFaceswipeClassesFront extends comFaceswipeClassesDefault
{
	function renderGallery($albumID)
	{
		$imageClass = new comFaceswipeClassesImages;
		$images 	= $imageClass->getImagesByALbumID($albumID);
		$rand 	 	= $imageClass->genRandomString();
		$albumTable = JTable::getInstance('album', 'faceswipetable');
		$albumTable->load($albumID);
		JHTML::stylesheet('front.css', 'components/com_faceswipe/assets/css/front/');
		JHTML::script('faceswipe-front.js', 'components/com_faceswipe/assets/js/'); 
		
		$countImages = count($images);
		$count 		 = 1;
		$html 		 = '';
		
		if ($countImages >= 6)
		{
			$html = '<div class="fs-front-gallery"><div id="fs-front-gallery-'.$rand.'">';
			foreach ($images as $image)
			{
				if ($count >= 7) break;
				
				$html .= '<div class="fs-front-image-block"><a target="_blank" href="'.htmlspecialchars($image->image_link).'">
							<img src="'.$image->image_thumbs.'" alt="'.htmlspecialchars($image->image_title).'"/>
						</a></div>';
				
				$count++;
			}
			$html .= '</div>
						<div class="fs-front-control">
							<a target="_blank" href="?option=com_faceswipe&view=albums&layout='.$albumTable->album_fullscreen_layout.'&format='.$albumTable->album_fullscreen_layout.'&album_id='.$albumID.'">
								<span title="'.JText::_('FACESWIPE_FRONT_FULLSCREEN').'">[ x ]</span>
							</a>
						</div>
					</div>';
			
			$html .= '<script type="text/javascript">
						window.addEvent("domready", function(){
							FaceSwipeFront.gallery("'.$rand.'");
						});
					 </script>';
			
			$facebookClass = new comFaceswipeClassesFacebook;
			$url = JURI::base().'?index.php&option=com_faceswipe&view=albums&layout=front&album_id='.$albumID;
			
			$html .= '<div class="fs-social-box">';
			
			if($albumTable->album_comment == 1)
			{
				$html .= '<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>';
				$html .= '<fb:like href="'.$url.'" send="true" layout="button_count" width="450" show_faces="true" font=""></fb:like>';
				$html .= '<div id="fs-comment" class="fs-comment-box">';
				$html .= $facebookClass->commentBox($url);
				$html .= '</div>';
			}
			
			$html .= '</div>';
		} else {
			$html .= JText::_('FACESWIPE_GALLERY_6_IMAGES');
		}
		return $html;
	}
	
	function renderSlideShow2($albumID)
	{
		JHTML::_('behavior.mootools');
		$imageClass = new comFaceswipeClassesImages;
		$images 	= $imageClass->getImagesByALbumID($albumID);
		$rand 	 	= $imageClass->genRandomString();
		$albumTable = JTable::getInstance('album', 'faceswipetable');
		$styleTable = JTable::getInstance('style', 'faceswipetable');
		
		if (!$albumTable->load($albumID)) return false;
		if (!$styleTable->load($albumTable->style_id)) return false;
		
		JHTML::stylesheet('slideshow.css', 'components/com_faceswipe/assets/css/slideshow2/');
		JHTML::stylesheet('front.css', 'components/com_faceswipe/assets/css/front/');
		JHTML::script('slideshow.js', 'components/com_faceswipe/assets/js/slideshow2/');
		JHTML::script('slideshow.kenburns.js', 'components/com_faceswipe/assets/js/slideshow2/');
		JHTML::script('slideshow.push.js', 'components/com_faceswipe/assets/js/slideshow2/');
		JHTML::script('slideshow.fold.js', 'components/com_faceswipe/assets/js/slideshow2/'); 
		
		$countImages = count($images);
		$count 		 = 1;
		$html 		 = '';
		$data = array();
		
		if ($countImages) 
		{
			foreach ($images as $image)
			{
				$data[$image->image_source] = array('caption' => $image->image_title, 'thumbnail' => $image->image_thumbs);
			}
			$html .= '<style type="text/css">
						#faceswipe-slide-'.$rand.' .slideshow-thumbnails ul{margin: 0; padding: 0;}
						#faceswipe-slide-'.$rand.' a, #faceswipe-slide-'.$rand.' a:hover, #faceswipe-slide-'.$rand.' a:active, #faceswipe-slide-'.$rand.' a:focus{ background-color: transparent; color:#fff;}
					 </style>';
			$html .= '<div class="faceswipe-wrapper" style="width:'.$styleTable->style_width.'; height:'.$styleTable->style_height.'; margin:auto;">
						<div id="faceswipe-slide-'.$rand.'" class="faceswipe-slideshow">
							<a target="_blank" href="?option=com_faceswipe&view=albums&layout='.$albumTable->album_fullscreen_layout.'&format='.$albumTable->album_fullscreen_layout.'&album_id='.$albumID.'">
								<img src="'.$image->image_source.'" alt="'.htmlspecialchars($image->image_title).'">
							</a>
					 	</div>
					 </div>
					 <div style="clear:both;"></div>
					 <div class="avatarslide-copyright" style="text-align: center; margin: 10px 0 0 0;">
						&copy; JoomAvatar.com
						<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Extension</a>-
						<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Template</a>
					</div>';	
			$html .= '
					<script type="text/javascript">
						window.addEvent("domready", function(){
							var data = '.json_encode($data).';
							var parentSize = $("faceswipe-slide-'.$rand.'").getParent().getSize();
							var options = { 
											height : parentSize.y,
											width : parentSize.x, 
											duration : '.$styleTable->style_duration.', 
											thumbnails : '.(($styleTable->style_thumbnail) ? 'true' : 'false').',
											captions : '.(($styleTable->style_caption) ? 'true' : 'false').',
											random : '.(($styleTable->style_random) ? 'true' : 'false').',  
											paused : '.(($styleTable->style_paused) ? 'true' : 'false').',
											title : '.(($styleTable->style_title) ? 'true' : 'false').',
											loop : '.(($styleTable->style_loop) ? 'true' : 'false').',
											controller : '.(($styleTable->style_controller) ? 'true' : 'false').',
											overlap: true,
											transition: "'.$styleTable->style_transition.'"
											'.(($styleTable->style_thumbnail) ? 
												', thumbnails: {image:{width: "'.$styleTable->style_thumbnail_image_width.'", 
																height: "'.$styleTable->style_thumbnail_image_height.'"}		
												}' : 
												'').'
										}
							new Slideshow'.$styleTable->style_showcase.'("faceswipe-slide-'.$rand.'", data, options);
						});
					</script>
			';
			
			$facebookClass = new comFaceswipeClassesFacebook;
			$url = JURI::base().'?index.php&option=com_faceswipe&view=albums&layout=front&album_id='.$albumID;
			
			$html .= '<div class="fs-social-box">';
			
			if($albumTable->album_comment == 1)
			{
				$html .= '<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>';
				$html .= '<fb:like href="'.$url.'" send="true" layout="button_count" width="450" show_faces="true" font=""></fb:like>';
				$html .= '<div id="fs-comment" class="fs-comment-box">';
				$html .= $facebookClass->commentBox($url);
				$html .= '</div>';
			}
			
			$html .= '</div>';
		}
		
		return $html;
	}
}