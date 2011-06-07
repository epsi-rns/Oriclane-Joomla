<?php defined('_JEXEC') or die('Restricted access'); /* no direct access */  

	$items = array();
	$items[] = 'title="'.$params->get('title').'"';
	$items[] = 'subtitle="'.$params->get('subtitle').'"';
	
	switch($params->get('adapter')) {
	case 0: 
		$items[] = 'picasa_user="'.$params->get('picasa_user').'"';
		$items[] = 'picasa_album="'.$params->get('picasa_album').'"';
		break;
	case 1: 	
		$items[] = 'source="'.$params->get('jsdata').'"';
	break;
	}

	$plugintext='{noobslide '.implode($items, ' ').'}';	
	echo JHTML::_('content.prepare', $plugintext);

