<?php
/**
 * @version		$Id: view.html.php 27 2011-10-02 01:51:00Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'images.php';
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'facebook.php';
class FaceSwipeViewAlbum extends JView
{
	protected $item;
	protected $form;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		JHTML::stylesheet('faceswipe.css', 'administrator/components/com_faceswipe/assets/css/');
		
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		
		$imageObj 		= new comFaceswipeClassesImages();
		$this->images 	= $imageObj->getImagesByALbumID($this->item->album_id);
				
		$code = JRequest::getVar('code');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->album_id == 0);
		
		JToolBarHelper::title(JText::_('COM_FACESWIPE_MANAGER_ALBUM'), 'albums.png');
		JToolBarHelper::apply('album.apply');
		JToolBarHelper::save('album.save');
		JToolBarHelper::custom('album.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		
		if (empty($this->item->id))  {
			JToolBarHelper::cancel('album.cancel');
		} else {
			JToolBarHelper::cancel('album.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
	}
}
