<?php defined('_JEXEC') or die(); // no direct access

class JHTMLMoolib
{	/* public static for PHP5 */
	
	function noobslide($debug = null) 
	{
		JHTML::_('behavior.mootools');
		
		$assets = JURI::base() .'media/libraries/js/';
		if ($debug)
			JHTML::_('script', 'mooclass.noobSlide.js', $assets);
		else
			JHTML::_('script', 'mooclass.noobSlide.packed.js', $assets);
	}	
	
	function reflection($debug = null) 
	{
		JHTML::_('behavior.mootools');
		
		$assets = JURI::base() .'media/libraries/js/';
		JHTML::_('script', 'mooclass.reflection.js', $assets);		
	}	
}	
