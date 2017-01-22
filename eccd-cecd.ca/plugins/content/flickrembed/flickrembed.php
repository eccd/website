<?php
/**
*
* @copyright Copyright (C) 2010 Lorenzo Carbonell. All rights reserved.
* @license GNU/GPL
*
* Version 1.6
*
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
* Flickr Album Embedder Content Plugin
*
*/
class plgContentFlickrEmbed extends JPlugin
{

	/**
	* Constructor
	*
	* @param object $subject The object to observe
	* @param object $params The object that holds the plugin parameters
	*/
	function plgContentFlickrEmbed( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	/**
	* Example prepare content method
	*
	* Method is called by the view
	*
	* @param object The article object. Note $article->text is also available
	* @param object The article params
	* @param int The 'page' number
	*/
	function onPrepareContent( &$article, &$params, $limitstart )
		{
		global $mainframe;
	
		if ( JString::strpos( $article->text, 'Flickr_albumid' ) === false ) {
		return true;
		}

		$article->text = preg_replace('|(Flickr_albumid=([a-zA-Z0-9_-]+))|e', '$this->FlickrCodeEmbed("\2")', $article->text);
	
		return true;
	}

 	/**
	* Example prepare content method in Joomla 1.6/1.7/2.5
	*
	* Method is called by the view
	*
	* @param object The article object. Note $article->text is also available
	* @param object The article params
	*/   
	function onContentPrepare($context, &$row, &$params, $page = 0){
		jimport('joomla.html.parameter');
        
 		if ( JString::strpos( $row->text, 'Flickr_albumid' ) === false ) {
            return true;
		}
		$row->text = preg_replace('|(Flickr_albumid=([a-zA-Z0-9_-]+))|e', '$this->FlickrCodeEmbed("\2")', $row->text);
		return true;        
	}
	

	function FlickrCodeEmbed( $vCode )
	{

		$plugin =& JPluginHelper::getPlugin('content', 'flickrembed');
	 	$params = new JParameter( $plugin->params );

		$width = $params->get('width', 550);
		$height = $params->get('height', 445);
		$tuser = $params->get('tuser');
    return '<object width="'.$width.'" height="'.$height.'"> <param name="flashvars" value="offsite=true&lang=es-us&page_show_url=%2Fphotos%2F'.$tuser.'%2Fsets%2F'.$vCode.'%2Fshow%2F&page_show_back_url=%2Fphotos%2F'.$tuser.'%2Fsets%2F'.$vCode.'%2F&set_id='.$vCode.'&jump_to="></param> <param name="movie" value="http://www.flickr.com/apps/slideshow/show.swf?v=71649"></param> <param name="allowFullScreen" value="true"></param><embed type="application/x-shockwave-flash" src="http://www.flickr.com/apps/slideshow/show.swf?v=71649" allowFullScreen="true" flashvars="offsite=true&lang=es-us&page_show_url=%2Fphotos%2F'.$tuser.'%2Fsets%2F'.$vCode.'%2Fshow%2F&page_show_back_url=%2Fphotos%2F'.$tuser.'%2Fsets%2F'.$vCode.'%2F&set_id='.$vCode.'&jump_to=" width="'.$width.'" height="'.$height.'"></embed></object>';
	}
}
