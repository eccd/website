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

class JFormFieldStyletransition extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Styletransition';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$options 	= array();
		$options[] 	= JHtml::_('select.option', 'sine:in:out', 'sine:in:out');
		$options[] 	= JHtml::_('select.option', 'back:in:out', 'back:in:out');
		$options[] 	= JHtml::_('select.option', 'back:out', 'back:out');
		$options[] 	= JHtml::_('select.option', 'elastic:out', 'elastic:out');
		$options[] 	= JHtml::_('select.option', 'bounce:out', 'bounce:out');
		
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}
