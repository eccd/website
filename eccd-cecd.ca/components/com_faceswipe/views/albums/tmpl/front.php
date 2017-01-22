<?php
/**
 * @version		$Id: front.php 49 2011-12-26 19:48:11Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

	require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'classes'.DS.'front.php';
	$albumID 		= JRequest::getInt('album_id', 0);
	$frontClass 	= new comFaceswipeClassesFront;
	$galleryHTML 	= $frontClass->renderSlideShow2($albumID);
	
	echo $galleryHTML;
	
	
