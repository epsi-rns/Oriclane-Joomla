<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentLinkbutton extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'linkbutton') === false) {
			return true;
		}	

		// expression to search for	(using non greedy ?)
		$regex = '/{linkbutton\s+(.*?)}/i';	
		$matches	= array();			
		
	 	// find all instances of plugin and put in $matches
		preg_match_all( $regex, $article->text, $matches, PREG_SET_ORDER );

 		// Number of plugins
 		if ( count( $matches ) ) $this->initAssets();

 		// plugin only processes if there are any instances of the plugin in the text		
		foreach($matches as $match)
 			$this->process( $article, $match);
		
  		// removes tags without matching module positions
		$article->text = preg_replace( $regex, '', $article->text );
	}
	
	function initAssets()
	{
		$assets = JURI::base() .'media/libraries/';
		JHTML::_('stylesheet', 'linkbutton.css', $assets.'css/');			
	}
	
	function process( &$row, &$match )
	{
		$type='attach';
		if (preg_match('/type="(.*?)"/', $match[1], $value)) 
			$type = $value[1];	
			
		$href='#';
		if (preg_match('/href="(.*?)"/', $match[1], $value)) 
			$href = $value[1];	
		
		$text=JText::_('Download...');				
		if (preg_match('/text="(.*?)"/', $match[1], $value)) 
			$text = $value[1];	

		if (!empty($type)) 
			$text = '<span class="file-button file_'.$type.'">'.$text.'</span>';

		$content	= '	
<div class="generic-button"><a class="nofavicon" href="'.$href.'">
'.$text.'
</a></div>'."\n";

		$row->text 	= str_replace($match[0], $content, $row->text );
	}		
}
