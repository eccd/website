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

class FaceSwipeViewAlbums extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		JHTML::stylesheet('faceswipe.css', 'administrator/components/com_faceswipe/assets/css/');
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
		$this->addToolbar();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_FACESWIPES_MANAGER_ALBUMS'), 'albums.png');
		JToolBarHelper::addNew('album.add');
		JToolBarHelper::editList('album.edit');
		JToolBarHelper::divider();
		JToolBarHelper::publish('albums.publish', 'JTOOLBAR_PUBLISH', true);
		JToolBarHelper::unpublish('albums.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'albums.delete', 'JTOOLBAR_DELETE');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_faceswipe');
		JToolBarHelper::divider();
	}
}
