<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentSimpleSlideShow extends JPlugin
{

	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'simpleslideshow') === false) {
			return true;
		}	
		
		// initialize variables
 		$this->path_images = JURI::base().'media/user/images/';

		// expression to search for	(using non greedy ?)
		$regex = '/{simpleslideshow\s+(.*?)}/i';
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
		JHTML::_('script', 'moohelper.simpleslideshow.js', $assets.'js/');	
		
		$document	= & JFactory::getDocument();	
		$style = '
#slideshow-container	{ width:512px; height:384px; position:relative; }
#slideshow-container img { display:block; position:absolute; top:0; left:0; z-index:1; }

';
		$document->addStyleDeclaration($style);
	}
	
	function process( &$row, &$match )
	{
		$path = '';	
		if (preg_match('/path="(.*?)"/', $match[1], $value)) 
			$path = $value[1].'/';		
		$path = $this->path_images.$path;				
		
		$items=array();
		if (preg_match('/images="(.*?)"/', $match[1], $value)) 
		{
			$str = preg_replace('/\s*/', '', $value[1]);
			$items=explode(',', $str);	
		}
		
		$content = '';		
		foreach ($items as $item)		
			$content .= "\t\t".'<img src="'.$path.$item.'" />'."\n"; 
			
		$content	= '		
<div id="slideshow-container">
'."\n".$content.'
</div>'."\n";		
			
		$row->text 	= str_replace($match[0], $content, $row->text );
	}
}
