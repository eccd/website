<?php

/**
 * @version		$Id: view.carousel.php 9 2011-09-27 17:58:21Z trung $
 * @copyright	Copyright (C) 2010 - 2011 Open Source Matters, Inc. All rights reserved.
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'carousel.php';
class FaceSwipeViewAlbums extends JView
{
	function display($tpl = null) 
	{
		$albumID = JRequest::getInt('album_id', 0);
		$carouselClass = new comFaceswipeClassesCarousel;
		$gallery = $carouselClass->renderGallery($albumID);
		
		echo $gallery; jexit();
		
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		parent::display($tpl);
	}
}
