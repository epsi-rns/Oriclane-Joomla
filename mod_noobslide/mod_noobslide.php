<?php
/**
* n00b
*
* @version 0.2.0
* @package noobSlide for Mootools 1.2
* @copyright (C) 2009 - 2009 E.R. Nurwijayadi
* @url http://www [dot] net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
**/

defined('_JEXEC') or die('Restricted access');

function checkDependency()
{	
	$plugin =& JPluginHelper::getPlugin('content', 'noobslide');        
	if ( empty($plugin)) {
		$app = &JFactory::getApplication();
		$msg = 'You should activate noobslide plugin '
		.'to get this module work properly.';
		$app->enqueueMessage($msg);
	} 				
}

checkDependency();

require(JModuleHelper::getLayoutPath('mod_noobslide'));
