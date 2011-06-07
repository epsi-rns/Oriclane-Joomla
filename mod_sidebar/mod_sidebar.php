<?php
/**
* @version 0.1.0
* @package Moo Scroll Side Bar
* @copyright (C) 2009 - 2009 E.R. Nurwijayadi
* @url http://www [dot] net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
* @original-script http://davidwalsh.name/scroll-sidebar
* @dependency Mootools 1.2.4
**/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.mootools');

$assets = 'media/mod_sidebar/assets/';
JHTML::_('stylesheet', 'sidebar.css', $assets);
JHTML::_('script', 'mooclass.sidebar.js', $assets);


require(JModuleHelper::getLayoutPath('mod_sidebar'));
