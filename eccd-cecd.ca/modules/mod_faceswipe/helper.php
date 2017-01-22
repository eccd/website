<?php
/**
 * @version		$Id: helper.php 49 2011-12-26 19:48:11Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'classes'.DS.'front.php';

$albumID = $params->get('album_id');

$albumTable = JTable::getInstance('album', 'faceswipetable');

if (!$albumTable->load($albumID)){
	return;	
}

$user 			= JFactory::getUser();
$levels 		= $user->getAuthorisedViewLevels();

if (in_array($albumTable->access, $levels) == false) {
	return;
}
	
if ($albumTable->published == 0) {
	return;
}
	
$frontClass = new comFaceswipeClassesFront;
$gallery 	= $frontClass->renderSlideShow2($albumID);
echo $gallery;







