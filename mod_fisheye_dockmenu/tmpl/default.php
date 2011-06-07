<?php defined('_JEXEC') or die('Restricted access'); /* no direct access */  
$images = JURI::root(true).'/media/mod_fisheye_dockmenu/images';
$assets = JURI::root(true).'/media/mod_fisheye_dockmenu/assets';
?>
	<div id="lens-fly">
	<div id="lens-container">
	<div class="lens-icon">
	<?php for ($i = 1; $i <= 4; $i++): ?>
		<?php if ($params->get( "menu${i}_status" )) : ?>
		<a href="<?php echo $params->get( "menu${i}_url" ); ?>">
			<img src="<?php echo $images; ?>/<?php echo $params->get( "menu${i}_img" ); ?>"
			style="behavior: url('<?php echo $assets?>/png.htc');" />
			<span><?php echo $params->get( "menu${i}_txt" ); ?></span>
		</a>
		<?php endif; ?>
	<?php endfor; ?>	
	</div></div></div>
