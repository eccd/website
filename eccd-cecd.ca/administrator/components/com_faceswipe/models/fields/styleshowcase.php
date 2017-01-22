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

class JFormFieldStyleshowcase extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Styleshowcase';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$options 	= array();
		$options[] 	= JHtml::_('select.option', '.KenBurns', JText::_('FACESWIPE_KENBURNS'));
		$options[] 	= JHtml::_('select.option', '.Push', JText::_('FACESWIPE_PUSH'));
		$options[] 	= JHtml::_('select.option', '.Fold', JText::_('FACESWIPE_FOLD'));
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}
