<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentKwicks extends JPlugin
{

	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'kwicks') === false) {
			return true;
		}	

		// initialize variables
 		$this->path_images = JURI::base().'media/user/images/';

		// expression to search for	(using non greedy ?)
		$regex = '/{kwicks\s+(.*?)}/i';	
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
		JHTML::_('script', 'mooclass.kwicks.js', $assets.'js/');	
		
		$document	= & JFactory::getDocument();	
		$style = '
#kwick						{ width:590px; }
	#kwicks 				{ height:120px; list-style-type:none; margin:0; padding:0; }
#kwick span					{ float:left; }
#kwick .kwick 				{ display:block; cursor:pointer; overflow:hidden; height:120px; width:146px; }
#kwick span .kwick span 	{ display:none; }
';
		$document->addStyleDeclaration($style);		

		$script = "\t"
		."window.addEvent('domready', function() {"
		."\n\t\t"."var kwicks = new Kwicks('kwicks');"
		."\n\t});";
		$document->addScriptDeclaration($script);
	}
	
	function process( &$row, &$match )
	{
		$ref ='#';	
		if (preg_match('/ref="(.*?)"/', $match[1], $value)) 
			$ref = $value[1];	
			
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
		
		if (count($items)>=4)
		{
			$bgcolor = array('#53b388', '#5a69a9', '#c26468', '#bf7cc7');
			
			$style = array();
			foreach ($items as $i => $item) 
			$style[] =  '#kwick #kwick'.$i.'	'
			.'{ background: '.$bgcolor[$i].' url('.$path.$item.') no-repeat; }'."\n";
			
			$document	= & JFactory::getDocument();			
			$document->addStyleDeclaration(implode($style, ''));								
		}	
		$content = '';		
		for ($i = 0; $i <= 3; $i++) 
			$content .= "\t\t".'<span><a href="'.$ref.'" class="kwick" id="kwick'.$i.'">'
				.'<span>'.$i.'</span></a></span>'."\n"; 
		
		$content	= '		
<div id="kwick">
	<div id="kwicks">'."\n".$content.'	</div>
</div>'."\n";		
			
		$row->text 	= str_replace($match[0], $content, $row->text );
	}
}
