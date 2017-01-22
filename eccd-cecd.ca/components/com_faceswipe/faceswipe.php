<?php
/**
 * @version		$Id: faceswipe.php 56 2012-01-04 16:23:43Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Include dependancies
jimport('joomla.application.component.controller');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_faceswipe'.DS.'tables');
$controller	= JController::getInstance('FaceSwipe');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();