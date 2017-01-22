<?php
/**
 * @version		$Id: facebook.php 10 2011-09-27 18:01:56Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if (!class_exists('Facebook')) {
	require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_faceswipe'.DS.'libraries'.DS.'facebook'.DS.'facebook.php';
	
}

class comFaceswipeClassesFacebook
{
	private static $_client = null;
	public static $_facebook_api_key;
	public static $_facebook_secret_key;
	
	public static function getAPIKey() {
		$params = JComponentHelper::getParams('com_faceswipe');
		return self::$_facebook_api_key 	= $params->get('facebook_api_key');
	}
	
	public static function getSecretKey() {
		$params = JComponentHelper::getParams('com_faceswipe');
		return self::$_facebook_secret_key = $params->get('facebook_secret_key');
	}
	public static function getInstance ()
	{
		if (self::$_client == null) 
		{
			self::$_client 	= new Facebook(array(
			  	'appId'  => self::getAPIKey(),
			  	'secret' => self::getSecretKey(),
			  	'cookie' => true
			));
		}
		// Return client instance
		return self::$_client;
	}
	
	public static function getAlbums ()
	{
		try {
			$client = self::getInstance();
			$albums = $client->api('me/albums');
			foreach($albums as $album){
				
				return $album;
			}
		}
		catch (Exception $ex) {
			return array();
		}
	}
	
	public static function getAlbumById ($aid)
	{
		try {
			$client = self::getInstance();
			$albums = $client->api("{$aid}");
			return $albums;
		}
		catch (Exception $ex) {
			return array();
		}
	}
	
	public static function getPicturesFromAlbum ($aid)
	{
		try {
			$client = self::getInstance();
			$albums = $client->api("/{$aid}/photos");
			foreach($albums AS $photo){
				return $photo;
			}
		}
		catch (Exception $ex) {
			return array();
		}
	}
	
	public static function getLoginUrl ($return)
	{
		$permission = array();
		$permission[] = 'user_photos';
		
		$client = self::getFacebookClient();
		
		return $client->getLoginUrl(array(
			'req_perms'  => implode(',', $permission)
		));
	}
	
	function commentBox($url)
	{
		$html = '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		 		<fb:comments href="'.$url.'" num_posts="10" ></fb:comments>
	 			<script type="text/javascript">
					function showCommentBox()
					{
						$$(".fs-comment-box").each(function(el){
							el.getElement("iframe").style.width = "100%";
							el.getElement("iframe").style.height = "auto";
						});
					}
						
					window.addEvent("domready", function(){
						showCommentBox.delay(3000);
					});
				 </script>';
		
		return $html;
	}
}