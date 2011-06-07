<?php defined('_JEXEC') or die('Restricted access'); /* no direct access */  ?>

<div id="sidebar-menu">
	<ul>
		<li><a href="#<?php echo $params->get('pagetop'); ?>" 
		id="sidebar-menu-top" title="Top of Page">Top of Page</a></li>
		<li><a href="<?php echo $params->get('home'); ?>" 
		id="sidebar-menu-home" title="Go to the Homepage">Homepage</a></li>
<?php if ($params->get('tweeter')): ?>
		<li><a href="<?php echo $params->get('tweeter'); ?>" 
		id="sidebar-menu-twitter" title="Follow on Twitter">Follow on Twitter</a></li>
<?php endif; ?>
<?php if ($params->get('facebook')): ?>
		<li><a href="<?php echo $params->get('facebook'); ?>" 
		id="sidebar-menu-facebook" title="Share and connect">Facebook</a></li>
<?php endif; ?>
		<li><a href="#<?php echo $params->get('pagebottom'); ?>" 
		id="sidebar-menu-bottom" title="Bottom of Page">Bottom of Page</a></li>		
	</ul>
</div>
