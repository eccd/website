<?php
/**
 * @package		Twitter Widget
 * @copyright	svenskis@mail.com all rights reserved. All rights reserved.
 * @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 */

// no direct access
defined('_JEXEC') or die;

// Include the helper file
require_once dirname(__FILE__).'/helper.php';

// if cURL is disabled, then extension cannot work
if(!is_callable('curl_init')){
	$data = false;
	$curlDisabled = true;
}
else {
	$model = new modTwitterwidgetHelper();
	$model->addStyles($params);
	$data = $model->getData($params);
}

if($data) {
	require JModuleHelper::getLayoutPath('mod_twitterwidget', $params->get('layout', 'default'));
}
else {
	require JModuleHelper::getLayoutPath('mod_twitterwidget', 'error/error');
}
