<?php 
  

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');


class formmakerController extends JController
{


	function element()
	{
		$model	= $this->getModel( 'element' );
		$view	= $this->getView( 'element');
		$view->setModel( $model, true );
		$view->display();
	}

	function select_article()
	{
		$model	= $this->getModel( 'select_article' );
		$view	= $this->getView( 'select_article');
		$view->setModel( $model, true );
		$view->display();
	}

}

?>