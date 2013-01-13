<?php
/**
* @version 0.1.0
* @package iluni.net
* @subpackage mod_articles_prevnext
* @copyright (C) 2013 - 2013 E.R. Nurwijayadi
* @url http://www [dot] net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
**/

defined('_JEXEC') or die('Restricted access');

$view = JRequest::getCmd('view');

if ($view == 'article')
{
    JHTML::_('behavior.mootools');

    $assets = 'media/mod_articles_prevnext/assets/';
    JHTML::_('stylesheet', 'nav_article.css', $assets);
    JHTML::_('script', 'moohelper.navslider.js', $assets);

    // Include the syndicate functions only once
    require_once dirname(__FILE__).'/helper.php';

    $prev = modArticlesPrevNextHelper::getPrev($params);
    $next = modArticlesPrevNextHelper::getNext($params);
    require(JModuleHelper::getLayoutPath('mod_articles_prevnext'));
}
