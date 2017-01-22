<?php
/**
 * @version		$Id: album.php 9 2011-09-27 17:58:21Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldStylethumbdirection extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Stylethumdirection';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$options 	= array();
		$options[] 	= JHtml::_('select.option', 'top', JText::_('FACESWIPE_BOTTOM'));
		$options[] 	= JHtml::_('select.option', 'right', JText::_('FACESWIPE_RIGHT'));
		$options[] 	= JHtml::_('select.option', 'bottom', JText::_('FACESWIPE_BOTTOM'));
		$options[] 	= JHtml::_('select.option', 'left', JText::_('FACESWIPE_LEFT'));
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}
