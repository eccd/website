<?php 
  
 /**

defined('_JEXEC') or die('Restricted access');

class JElementAuthor extends JElement
{

	var	$_name = 'Author';

	function fetchElement($name, $value, &$node, $control_name)
	{
		return JHTML::_('list.users', $control_name.'['.$name.']', $value);
	}
}