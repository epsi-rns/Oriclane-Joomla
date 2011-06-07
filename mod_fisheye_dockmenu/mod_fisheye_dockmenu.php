<?php
/**
* Fish Eye
*
* @version 0.1.0
* @package Fish Eye Dock Menu for Mootools 1.3
* @copyright (C) 2009 - 2009 E.R. Nurwijayadi
* @url http://www [dot] net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
**/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.mootools');

$assets = 'media/mod_fisheye_dockmenu/assets/';
JHTML::_('stylesheet', 'dock.css', $assets);
JHTML::_('script', 'dock.js', $assets);

require(JModuleHelper::getLayoutPath('mod_fisheye_dockmenu'));
