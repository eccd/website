<?php
/**
 * @version		$Id: default.php 56 2012-01-04 16:23:43Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_faceswipe'.DS.'tables');
class comFaceswipeClassesDefault{
	function __construct(){
		$this->_db = JFactory::getDBO();
	}
	
	function genRandomString() 
	{
	    $length     = 10;
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $string 	= '';
	        
	    for ($p = 0; $p < $length; $p++) {
	    	$string .= $characters[mt_rand(1, strlen($characters)) - 1];
	    }
	    return $string;
	}
}