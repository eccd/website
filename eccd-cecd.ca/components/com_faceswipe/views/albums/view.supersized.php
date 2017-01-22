<?php
/**
 * @version		$Id: view.supersized.php 9 2011-09-27 17:58:21Z trung $
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
		$albumID = JRequest::getInt('album_id', 0);
		
		$imageClass 	= new comFaceswipeClassesImages;
		$this->images 	= $imageClass->getImagesByALbumID($albumID);
		
		$this->albumTable = JTable::getInstance('album', 'faceswipetable');
		$this->albumTable->load($albumID);
		
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		parent::display($tpl);
	}
}
