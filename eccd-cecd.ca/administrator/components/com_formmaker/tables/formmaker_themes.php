<?php 
  
 /**

defined('_JEXEC') or die('Restricted access');

class Tableformmaker_themes extends JTable

{

var $id = null;
var $title = null;
var $css = null;
var $default = null;


function __construct(&$db)

{

parent::__construct('#__formmaker_themes','id',$db);

}

}

?>