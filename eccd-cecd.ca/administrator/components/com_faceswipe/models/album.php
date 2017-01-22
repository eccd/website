<?php
/**
 * @version		$Id: album.php 27 2011-10-02 01:51:00Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'images.php';
class FaceSwipeModelAlbum extends JModelAdmin
{
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_faceswipe.album', 'album', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	
	public function getTable($type = 'Album', $prefix = 'FaceSwipeTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_faceswipe.edit.album.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
	
	public function save($data)
	{
		$jform 		= JRequest::getVar('jform');
		$post		= JRequest::get('post');
		$albumTable = $this->getTable();
		$imageTable = $this->getTable('image');
		
		$albumTable->bind($jform);
		
		if (!$albumTable->store()) {
			return false;
		}
		
		$albumTable->reorder();
		$imageObj = new comFaceswipeClassesImages;
		
		if (isset($post['image_fb_id'])) 
		{
			$imageFBIDs 	= $post['image_fb_id'] ;
			$imageSources 	= $post['image_source'];
			$imageTitles 	= $post['image_title'];
			$imageDescs 	= $post['image_description'];
			$imageLinks 	= $post['image_link'];
			$imageIDs		= $post['image_id'];
			$imageThumbs 	= $post['image_thumb'];
			$imageDatas		= $post['image_data'];
			$imageAlbumFB  	= $post['image_fb_album_id'];
			
			$imageObj 		= new comFaceswipeClassesImages;
			$availFBID 		= $imageObj->getImageFBIDByAlbumID($albumTable->album_id);
			$imageDeletes 	= array_diff($availFBID, $imageFBIDs);
			
			$imageObj->deleteImageByImageFBID($imageDeletes, $albumTable->album_id);
			
			foreach ( $imageFBIDs as $imageFBID)
			{
				$imageTable->load($imageIDs[$imageFBID]);
				$imageTable->image_title 		= $imageTitles[$imageFBID];
				$imageTable->image_description 	= $imageDescs[$imageFBID];
				$imageTable->image_link			= $imageLinks[$imageFBID];
				$imageTable->image_thumbs 		= $imageThumbs[$imageFBID];
				$imageTable->image_source 		= $imageSources[$imageFBID];
				$imageTable->image_fb_id 		= $imageFBID;
				$imageTable->album_id 			= $albumTable->album_id;
				$imageTable->image_data			= json_encode($imageDatas[$imageFBID]);
				$imageTable->image_fb_album_id	= $imageAlbumFB[$imageFBID];
				$imageTable->store();
				
				$imageTable->image_id = null;
			}
		} else {
			$imageObj->deleteAllImageByAlbumID($albumTable->album_id);
		}
		
		$this->setState($this->getName().'.id', $albumTable->album_id);
		
		$this->setState($this->getName().'.new', true);
		
		return true;
	}
	
	public function delete($pks = array())
	{
		$cids = implode(',', $pks);
		
		$query = ' DELETE FROM #__faceswipe_images 
				   WHERE album_id IN ('.$cids.')';
		
		$this->_db->setQuery($query);
		$this->_db->query();
		
		$query = ' DELETE FROM #__faceswipe_albums 
				   WHERE album_id IN ('.$cids.')';
		
		$this->_db->setQuery($query);
		$this->_db->query();
		
		return true;
	}
	
	public function checkout($recordID = 0) {}
}