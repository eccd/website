<?php
/**
 * @version		$Id: images.php 27 2011-10-02 01:51:00Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'default.php');
class comFaceswipeClassesImages extends comFaceswipeClassesDefault
{
	function getImagesByALbumID($albumID)
	{
		$query = 'SELECT * FROM #__faceswipe_images WHERE album_id = '.(int)$albumID .' ORDER BY image_id DESC';
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();	
	}
	
	function getImageFBIDByALbumID($albumID)
	{
		$query = 'SELECT image_fb_id FROM #__faceswipe_images WHERE album_id = '.(int)$albumID;
		$this->_db->setQuery($query);
		return $this->_db->loadResultArray();
	}
	
	function deleteImageByImageFBID($imageFBID = array(), $albumID)
	{
		if (count($imageFBID))
		{
			$images = implode(',', $imageFBID);
			
			$query = 'DELETE FROM #__faceswipe_images 
				  WHERE album_id = '.(int)$albumID . '
				  AND image_fb_id IN ('.$images.');
			';
			
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}
	
	function deleteAllImageByAlbumID($albumID = 0)
	{
		if ($albumID)
		{
			$query = 'DELETE FROM #__faceswipe_images 
				  WHERE album_id = '.(int)$albumID;
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}
	
}