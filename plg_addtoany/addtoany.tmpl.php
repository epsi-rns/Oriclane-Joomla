<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

	$button = $this->params->get('button');
	$title = $this->params->get('title');

	$path = 'media/plg_addtoany/images/buttons/';
	
	switch ($button) 
	{
	case 'favicon.png':
		$html = '
			<img src="'.$path.'favicon.png" 
			width="16" height="16" border="0" />&nbsp;'.$title.'
		';
		break;
	case 'share_save_106_16.gif':
		$html = '
			<img src="'.$path.'share_save_106_16.gif" 
			width="106" height="16" border="0" alt="'.$title.'"/>
		';
		break;
	case 'share_save_120_16.gif':
		$html = '
			<img src="'.$path.'share_save_120_16.gif" 
			width="120" height="16" border="0" alt="'.$title.'"/>
		';
		break;
	case 'share_save_171_16.png':
		$html = '
			<img src="'.$path.'share_save_171_16.png" 
			width="171" height="16" border="0" alt="'.$title.'"/>
		';		
		break;
	case 'share_save_256_24.png':
		$html = '
			<img src="'.$path.'share_save_256_24.png" 
			width="256" height="24" border="0" alt="'.$title.'"/>
		';
		break;
	default:
		$html = $title;	
	}
?>
<a class="a2a_dd" href="http://www.addtoany.com/share_save">
<?php echo $html; ?>
</a>
<script type="text/javascript" src="http://static.addtoany.com/menu/page.js">
</script> 

<?php
/*
<!-- AddToAny BEGIN -->
<a class="a2a_dd" href="http://www.addtoany.com/share_save">Share</a>
<script type="text/javascript">
var a2a_config = a2a_config || {};
a2a_config.num_services = 2;
</script>
<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
 * */
 ?>
