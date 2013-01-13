<?php
/**
* @version 0.1.0
* @package iluni.net
* @subpackage mod_articles_related
* @copyright (C) 2013 - 2013 E.R. Nurwijayadi
* @url http://www [dot] net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
**/

defined('_JEXEC') or die('Restricted access');

$view = JRequest::getCmd('view');

if ($view == 'article')
{
    // Include the syndicate functions only once
    require_once dirname(__FILE__).'/helper.php';

    $list = modArticlesRelatedHelper::getList($params);
    require(JModuleHelper::getLayoutPath('mod_articles_related'));
}
