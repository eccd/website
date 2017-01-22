<?php
/*------------------------------------------------------------------------
# mod_aixeenasocial.php - Aixeena Content Box (module)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Ciro Artigot http://twitter.com/ciroartigot
# copyright 	Copyright (c) 2013 Ciro Artigot All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website		http://aixeena.org

Icons by

Free Social Icons
by Neil Orange Peel , 143 icons total, Format: vector icons (SVG)
License: Free for commercial use (read me)
http://www.iconfinder.com/search/?q=iconset%3Afree-social-icons
*/
// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require(JModuleHelper::getLayoutPath('mod_aixeenasocial', $params->get('layout', 'default')));

?>