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

class JFormFieldStyle extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Style';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db 	= JFactory::getDBO();
		$query 	= $db->getQuery(true);
		
		$query->select('style_id as id, style_name as title');
		$query->from('#__faceswipe_styles');
		$db->setQuery((string)$query);
		
		$messages 	= $db->loadObjectList();
		$options 	= array();
		$options[] 	= JHtml::_('select.option', 0, JText::_('FACESWIPE_STYLE_SELECT_STYLE'));
		
		if ($messages)
		{
			foreach($messages as $message) 
			{
				$options[] = JHtml::_('select.option', $message->id, $message->title);
			}
		}
		
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}
