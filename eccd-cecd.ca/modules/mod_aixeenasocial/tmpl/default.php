<?php
/*------------------------------------------------------------------------
# mod_aixeenasocial.php - Aixeena Content Box (module)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Ciro Artigot http://twitter.com/ciroartigot
# copyright 	Copyright (c) 2013 Ciro Artigot All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website		http://aixeena.org

Icons by

Free Social Icons
by Neil Orange Peel , 143 icons total, Format: vector icons (SVG)
License: Free for commercial use (read me)
http://www.iconfinder.com/search/?q=iconset%3Afree-social-icons
*/

	defined('_JEXEC') or die;
	
	$document->addStyleSheet(JURI::base(true).'/modules/mod_aixeenasocial/assets/css/style.css');
	$document->addScript(JURI::base(true).'/modules/mod_aixeenasocial/assets/js/aixeena_social.js');
		
	$ordering_icons = $params->get('ordering_icons','twitter, facebook, googleplus, linkedin, youtube, vimeo, flickr, instagram, tumbrl, wordpress, github, rss, custom1, custom2, custom3, custom4, custom5');
	
	//echo $ordering_icons;
	
	$order_array = explode(',', $ordering_icons);
	$target = $params->get('target','_blank');
	if($target=='same') $target= '';
	
	$format = $params->get('format','circle');
	$size = $params->get('size','64');
	
	$textalign = $params->get('text-align','right');
	$color = $params->get('color','color');
	
	$imgaset = '';
	$addCSS = '';
	
	
	$backgroundimg_sw 		= $params->get('backgroundimg_sw',0);
	$backgroundimg 			= $params->get('backgroundimg','');
	$backgroundcolor_sw 	= $params->get('backgroundcolor_sw',0);
	$backgroundcolor 		= $params->get('backgroundcolor','#ffffff');
	$backgroundicon_sw 		= $params->get('backgroundicon_sw',0);
	$backgroundicon 		= $params->get('backgroundicon','#ffffff');
	$padding 				= $params->get('padding','');
	$shadow					= $params->get('shadow','');
	
	
	if($backgroundimg_sw) $addCSS .=  '
	#aixsoc'.$module->id.' { 
	background-image:url(././././'.$backgroundimg.')  ;
	background-repeat:no-repeat;
	background-position:left top;
	}';
	
	if($backgroundcolor_sw) $addCSS .=  '
	#aixsoc'.$module->id.' { 
	background-color:'.$backgroundcolor.';
	}';
	
	if($padding) $addCSS .=  '
	#aixsoc'.$module->id.' { 
	padding:'.$padding.';
	}';
	
	if($backgroundicon_sw) $addCSS .=  '
	#aixsoc'.$module->id.' .aixeena_social_href img{ 
	background-color:'.$backgroundicon.';
	}';

	
	if($addCSS) $document->addCustomTag("
<style type=".'"text/css"'.'>'.$addCSS.'</style>');
	
	
	foreach($order_array as $button) {
	
		$button =  trim($button);
		
		if($params->get($button,0)) {
		
			$src = JURI::base(true).'/modules/mod_aixeenasocial/assets/images/'.$format.'/'.$color.'/'.$size.'/'.$button.'.png';
			if($button=='custom1') $src = JURI::base(true).$params->get('custom1_src','');
			if($button=='custom2') $src = JURI::base(true).$params->get('custom2_src','');
			if($button=='custom3') $src = JURI::base(true).$params->get('custom3_src','');
			if($button=='custom4') $src = JURI::base(true).$params->get('custom4_src','');
			if($button=='custom5') $src = JURI::base(true).$params->get('custom5_src','');
			
			$href = $params->get($button.'_url','');
			$alt = $params->get($button.'_text','');
			$hover = $params->get('hover','rotate').$params->get($button.'_sufix','');

			$imgaset .= '
			<a href="'.$href.'" class="aixeena_social_href btn-href-'.$button.' " title="'.$alt.'" target='.$target.'><img src="'.$src.'" class="aixsocimg btn-'.$button.' '.$shadow.' aixeena_social_img_'.$hover .'  alt="'.$alt.'" /></a>';
		
		}

	}
	
	
	echo '
<div class="aixeenasocial aixeena_soc aixeena_soc-'.$textalign.'" id=aixsoc'.$module->id.'>'.$imgaset.'</div>';
?>