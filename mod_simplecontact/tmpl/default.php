<?php defined('_JEXEC') or die('Restricted access'); /* no direct access */ 
	// shortcut
	$vars = array('company', 'address', 'phone', 'hotline', 'fax', 'email');
	foreach($vars as $var) 	
		$$var = $params->get($var);
?>

		<div class="frontact">
			<div id="company"><strong><?php echo $company; ?></strong></div>
			<div id="address"><?php echo $address; ?></div>
			
			<?php if(!empty($phone)): ?>
			<div id="tel"><?php echo JText::_('phone'); ?>: <?php echo $phone ?></div>
			<?php endif; ?>
			
			<?php if(!empty($hotline)): ?>
			<div id="tel"><?php echo JText::_('Hotline'); ?>: <?php echo $hotline ?></div>
			<?php endif; ?>			
			
			<?php if(!empty($fax)): ?>
			<div id="fax"><?php echo JText::_('fax'); ?>: <?php echo $fax; ?></div>
			<?php endif; ?>
			
			<?php if(!empty($email)): ?>
			<div id="mail"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>		
			<?php endif; ?>
		</div>

