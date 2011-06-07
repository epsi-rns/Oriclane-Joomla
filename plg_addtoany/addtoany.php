<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');
jimport('joomla.html.parameter');

/**
* Plugin that loads module positions within contentz
*/
class plgContentAddtoany extends JPlugin
{
	private function get_output()
	{
		ob_start();
		include('addtoany.tmpl.php');		
		$outputbuffer = ob_get_contents();
		ob_end_clean();		

		return $outputbuffer;
	}

	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart=0)
	{
		$show_before = ! $this->params->get('position');

		// because from arguments above,
		// there is now way to determine featured/article content
		$content_type = JRequest :: getVar('view');
		$show_at = (array) $this->params->get('show_at');
		$show_at_type = in_array($content_type, $show_at);

		if ($show_before && $show_at_type) return $this->get_output();
		else return ''; 
	}
	
	public function onContentAfterDisplay($context, &$article, &$params, $limitstart=0)
	{
		$show_after = $this->params->get('position');

		// because from arguments above,
		// there is now way to determine featured/article content
		$content_type = JRequest :: getVar('view');
		$show_at = (array) $this->params->get('show_at');
		$show_at_type = in_array($content_type, $show_at);

		if ($show_after && $show_at_type) return $this->get_output();
		else return ''; 
	}	
}
