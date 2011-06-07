<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentMessage extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'message') === false) {
			return true;
		}	

		// expression to search for	(using non greedy ?)
		$regex = '/{message\s+(.*?)}/i';		
		
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
		// nothing to do, use oriclone css
	}
	
	function process( &$row, &$match )
	{
		$text = array();
		if (preg_match('/text="(.*?)"/', $match[1], $value)) 
			$text[] = $value[1];			
		
		if (preg_match('/modified/', $match[1], $value)) 
		{			
			$date = JHTML::_('date', $row->modified, JText::_('DATE_FORMAT_LC1'));
			$text[] = ' &#187;&#187; Update '.$date.' &#171;&#171; ';	
		}	
		
		$type='message';
		if (preg_match('/type="(.*?)"/', $match[1], $value)) 
			$type = $value[1];		
	
		$content	= '		
<dl id="system-message">
<dt class="'.$type.'">'.$type.'</dt>
<dd class="'.$type.' message fade">
	<ul>
		<li>'.implode($text, '<br/>').'</li>
	</ul>
</dd>
</dl>'."\n";		
			
		$row->text 	= str_replace($match[0], $content, $row->text );
	}
}
