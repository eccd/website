<?php

 /**
 
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JPATH_COMPONENT.DS.'controller.php' );

require_once('recaptchalib.php');

$controller = JRequest::getVar( 'controller' );

$classname    = 'formmakerController'.$controller;

$controller   = new $classname( );

$controller->execute( JRequest::getVar( 'task' ) );

$controller->redirect();

?>