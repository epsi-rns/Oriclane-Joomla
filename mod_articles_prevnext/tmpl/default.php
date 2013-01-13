<?php
/**
* @version 0.1.0
* @package iluni.net
* @subpackage mod_articles_prevnext
* @copyright (C) 2013 - 2013 E.R. Nurwijayadi
* @url http://www [dot] net/
* @author E.R. Nurwijayadi <epsi.rns@gmail.com>
**/

// no direct access
defined('_JEXEC') or die;
?>

<?php if(!empty($prev)): ?>
<div id="box_prev">
<div id="article_prev">
    <div id="article_prev_text">
    <a href="<?php echo $prev->link; ?>">
        <?php echo $prev->title; ?></a>
    </div>
    <div id="article_prev_image">
    &nbsp;
    </div>
</div>
</div>
<?php endif; ?>

<?php if(!empty($next)): ?>
<div id="box_next">
<div id="article_next">
    <div id="article_next_text">
        <a href="<?php echo $next->link; ?>">
            <?php echo $next->title; ?></a>
    </div>
    <div id="article_next_image">
    &nbsp;
    </div>
</div>
</div>
<?php endif; ?>
