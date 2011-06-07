<?php
/**
* @version 0.1.0
* @package Simple Contact
* @copyright (C) 2008 - 2008 E.R. Nurwijayadi
* @url http://www. [dot] .net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
**/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

JHTML::_('stylesheet', 'simplecontact.css', 'modules/mod_simplecontact/assets/');

	$document		= & JFactory::getDocument();

require(JModuleHelper::getLayoutPath('mod_simplecontact'));

