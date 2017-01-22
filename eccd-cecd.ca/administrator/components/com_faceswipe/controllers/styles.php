<?php
/**
 * @version		$Id: albums.php 9 2011-09-27 17:58:21Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');

class FaceSwipeControllerStyles extends JControllerAdmin
{
	public function getModel($name = 'Style', $prefix = 'FaceSwipeModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}