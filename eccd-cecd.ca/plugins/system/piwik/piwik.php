<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Piwik system plugin
 */
class plgSystemPiwik extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemPiwik( &$subject, $param )
	{
		parent::__construct( $subject, $param );

		$tcode = $this->params->def('piwik', 1);
	}

	/**
	 * Do something onAfterInitialise
	 */
	function onAfterRender()
	{
		$mainframe = JFACTORY::getApplication();
		
		if($mainframe->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false)
		{
			return;
		}

		$piwik = $this->params->get('tcode', '');
		
		$buffer = JResponse::getBody();

		$pos = strrpos($buffer, "</body>");


		if($pos > 0)
		{
			$buffer = substr($buffer, 0, $pos).$piwik.substr($buffer, $pos);

			JResponse::setBody($buffer);
		}

		return true;
		
		
	}

}
?>