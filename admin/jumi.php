<?php
/**
* @version   $Id$
* @package   Jumi
* @copyright (C) 2008 - 2011 Edvard Ananyan
* @license   GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

/*
 * Define constants for all pages
*/

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
define( 'COM_JUMI_DIR', 'images'.DS.'jumi'.DS );
define( 'COM_JUMI_BASE', JPATH_ROOT.DS.COM_JUMI_DIR );
define( 'COM_JUMI_BASEURL', JURI::root().str_replace( DS, '/', COM_JUMI_DIR ));

require_once( JPATH_COMPONENT.DS.'controller.php' );

$jinput = JFactory::getApplication()->input;

// Require specific controller if requested
if($controller = $jinput->getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

// Initialize the controller
$classname    = 'JumiController'.$controller;
$controller   = new $classname( );

$document = JFactory::getDocument();

$cssFile = JURI::base(true).'/components/com_jumi/assets/css/icons.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

// Perform the Request task
$controller->execute( $jinput->getCmd('task'));
$controller->redirect();

function addSub($title, $v, $controller = null, $image = null) {
    $enabled = false;
    $view = $jinput->getWord("view", 'showapplications');
    if($view == $v) {
        $img = $v;
        if($image != null) $img = $image;
        JToolBarHelper::title(( 'Jumi' )  .' - '. JText::_( $title), $img.'.png' );
        $enabled = true;
    }
    $link = 'index.php?option=com_jumi&view='.$v;
    if($controller != null) $link .= '&controller='.$controller;
    JSubMenuHelper::addEntry( JText::_($title), $link, $enabled);
}