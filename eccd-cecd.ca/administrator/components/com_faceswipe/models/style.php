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
class FaceSwipeModelStyle extends JModelAdmin
{
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_faceswipe.style', 'style', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	
	public function getTable($type = 'Style', $prefix = 'FaceSwipeTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_faceswipe.edit.style.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
	
	public function checkout($recordID = 0) {}
}