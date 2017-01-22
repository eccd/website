<?php
/**
 * @version		$Id: faceswipe.php 49 2011-12-26 19:48:11Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
JTable::addIncludePath(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'tables');
class plgContentFaceswipe extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$this->loadLanguage();
		$app = JFactory::getApplication();
		require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'classes'.DS.'front.php';
		
		$user 	= JFactory::getUser();
		$levels = $user->getAuthorisedViewLevels();
		
		$text = &$article->text;
		$pattern = '/\{faceswipe[a-z0-9=_\s]*\/\}/i';
		preg_match_all($pattern, $text, $matches);
		$arrayFormat = array();
		
		foreach ($matches[0] as $key => $format)
		{
			$matchAlbum  = false;
			$patternAlbum 	 = '/\balbum_id=[0-9]*\b/';
			preg_match($patternAlbum, $format, $albumInfo);
			
			if (count($albumInfo) > 0) $matchAlbum = true;
			
			if ($matchAlbum == true)
			{
				$albumID 		= explode('=', $albumInfo[0]);
				$albumID 		= $albumID[1];
				$albumTable 	= JTable::getInstance('album', 'FaceSwipeTable');
				
				$albumTable->load($albumID);
				
				if (in_array($albumTable->access, $levels) == false) {
					break;
				}
				
				if ($albumTable->published == 0) {
					break;
				}
				
				$frontClass = new comFaceswipeClassesFront;
				
				/*if (count($frontStyle)) {*/
					$galleryHTML 	= $frontClass->renderSlideShow2($albumID);
					
				/*} else {
					$galleryHTML 	= $frontClass->renderGallery($albumID);
				}*/
				
				$arrayFormat[]  = array('format' => $format, 'string' => $galleryHTML);
			}
		}	
		
		foreach ($arrayFormat as $item)
		{
			$pos = strpos($text, $item['format']);
				
			if (!empty($item['string']))
			{
				if ($pos !== false) {
				    $text = substr_replace($text, $item['string'], $pos, strlen($item['format']));
				}
			}
			else
			{
				 $text = substr_replace($text, '', $pos, strlen($item['format']));
			}
		}
	}
}
