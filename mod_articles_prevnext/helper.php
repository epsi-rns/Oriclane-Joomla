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


require_once JPATH_SITE.'/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modArticlesPrevNextHelper
{
    public static function getPrev(&$params)
    {
        $id = JRequest::getInt('id');
        $cat_id = JRequest::getInt('catid');

        $db = & JFactory::getDBO();

        $query = 'SELECT *' .
          ' FROM #__content' .
          ' WHERE id < '.$id .
          ' AND catid = '.$cat_id .
          ' AND access = 1'.
          ' ORDER BY id DESC';
        $db->setQuery($query);

        $item = $db->loadObject();

        if (!empty($item)) {
            $url = ContentHelperRoute::getArticleRoute($item->id, $item->catid);
            $item->link = JRoute::_($url);
        }

        return $item;
    }

    public static function getNext(&$params)
    {
        $id = JRequest::getInt('id');
        $cat_id = JRequest::getInt('catid');

        $db = & JFactory::getDBO();

        $query = 'SELECT *' .
          ' FROM #__content' .
          ' WHERE id > '.$id .
          ' AND catid = '.$cat_id .
          ' AND access = 1'.
          ' ORDER BY id ASC';
        $db->setQuery($query);

        $item = $db->loadObject();

        if (!empty($item)) {
            $url = ContentHelperRoute::getArticleRoute($item->id, $item->catid);
            $item->link = JRoute::_($url);
        }

        return $item;
    }
}
