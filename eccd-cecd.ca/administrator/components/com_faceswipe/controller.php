<?php
/**
 * @version		$Id: controller.php 49 2011-12-26 19:48:11Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

JSubMenuHelper::addEntry(JText::_('Albums'), 'index.php?option=com_faceswipe&view=albums');
JSubMenuHelper::addEntry(JText::_('Styles'), 'index.php?option=com_faceswipe&view=styles');

class FaceswipeController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
	
		JRequest::setVar('view', JRequest::getCmd('view', 'albums'));
		
		parent::display($cachable = false, $urlparams = false);
	}
}