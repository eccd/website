<?php

 /**

defined('_JEXEC') or die('Restricted access');
class Tablesessions extends JTable
{
var $id = null;

	function __construct(&$db)
	{
	parent::__construct('#__formmaker_sessions','id',$db);
	}
}
?>