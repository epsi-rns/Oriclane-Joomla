<?php defined('_JEXEC') or die('Restricted access'); /* no direct access */  
	$images = JURI::base().'/media/libraries/images';	
?>
<script type="text/javascript">
window.addEvent('domready',function(){
	var spinner = document.id('noob_cont').getElement('.noob_info');
	spinner.spin();
		
	myNoobSlide = function(images) {
		spinner.unspin();
		if (images.length>0) {				
			new mooNoobSlideHelper({
				<?php switch($this->lightbox_type) {	
					case 1: echo 'slimbox: true,'; break;
					case 2: echo 'mediaboxAdv: true,'; break;
				} ?>	
				path: (typeof noobPrefix)=='undefined'? '' 
					: '<?php echo JURI::base();?>' + noobPrefix,
				items: images
			});
		}
	}		
	
<?php if($adapter==1): ?>
	myNoobSlide(noobImages);
<?php else: ?>	
	new mooGooglePicasaWeb({
		user: '<?php echo $picasa_user; ?>',
		album: '<?php echo $picasa_album; ?>',
		onComplete: myNoobSlide
	}).send();
<?php endif; ?>	
});
</script>

<div id="noob_cont">

<div class="noob_sample">

	<div class="noob_thumbs" id="noob_thumbs_left">
		<div class="noob_nav_mask" id="noob_handles_1">
		<div class="noob_nav_box" id="noob_lnav_box">
		</div>
		</div>
	
		<div class="noob_nav_buttons">
			<span id="noob_lnav_prev"><img src="<?php echo $images; ?>/go-up.png"/></span>
			<span id="noob_lnav_next"><img src="<?php echo $images; ?>/go-down.png"/></span>
		</div>		
	</div>

	<div class="noob_thumbs" id="noob_thumbs_right">
		<div class="noob_nav_mask" id="noob_handles_2">
		<div class="noob_nav_box" id="noob_rnav_box">
		</div>
		</div>
	
		<div class="noob_nav_buttons">
			<span id="noob_rnav_prev"><img src="<?php echo $images; ?>/go-up.png"/></span>
			<span id="noob_rnav_next"><img src="<?php echo $images; ?>/go-down.png"/></span>
		</div>		
	</div>
	
	<div class="noob_mask">
		<div id="noob_main_box" title="click to zoom"></div>
		<div class="noob_info">
			<h4><?php echo $title; ?>
			<?php if($adapter==0): ?>			 
			<a class="nofavicon" href="<?php echo $picasa_link; ?>" target="_blank">Link</a>
			<?php endif; ?></h4>
			<p><?php echo $subtitle; ?></p>
		</div>
	</div>	
	
	<p class="noob_buttons">
		<span id="noob_prev">&lt;&lt; Previous</span>
		<span id="noob_playback">&lt;Playback</span>
		<span id="noob_stop">Stop</span>
		<span id="noob_play">Play &gt;</span>
		<span id="noob_next">Next &gt;&gt;</span>
	</p>
</div>
	
<div style="clear:both;"></div>
</div>	
