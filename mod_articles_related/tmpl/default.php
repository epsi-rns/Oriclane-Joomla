<?php
/**
* @version 0.1.0
* @package iluni.net
* @subpackage mod_articles_related
* @copyright (C) 2013 - 2013 E.R. Nurwijayadi
* @url http://www [dot] net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
**/

// no direct access
defined('_JEXEC') or die;

if (!empty($list)) { ?>
    <ul class="mostread col-3">
    <?php foreach ($list as $item) : ?>
        <li>
            <a href="<?php echo $item->link; ?>">
                <?php echo $item->title; ?></a>
        </li>
    <?php endforeach; ?>
    </ul>
<?php }
