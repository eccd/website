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
class FaceSwipeViewStyle extends JView
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
		$user = JFactory::getUser();
		JToolBarHelper::title(JText::_('COM_FACESWIPE_MANAGER_STYLE'), 'albums.png');
		JToolBarHelper::apply('style.apply');
		JToolBarHelper::save('style.save');
		JToolBarHelper::custom('style.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		
		if (empty($this->item->style_id))  {
			JToolBarHelper::cancel('style.cancel');
		} else {
			JToolBarHelper::cancel('style.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
	}
}
