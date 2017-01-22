<?php
/**
 * @version		$Id: default.php 48 2011-12-26 18:35:55Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'classes'.DS.'front.php';

$albumID = JRequest::getInt('album_id', 0);

$albumTable = JTable::getInstance('album', 'faceswipetable');

if (!$albumTable->load($albumID)){
	return;	
}

$user 	= JFactory::getUser();
$levels = $user->getAuthorisedViewLevels();

if (in_array($albumTable->access, $levels) == false) {
	return;
}
	
if ($albumTable->published == 0) {
	return;
}
	
$frontClass = new comFaceswipeClassesFront;
$gallery 	= $frontClass->renderSlideShow2($albumID);
echo $gallery;