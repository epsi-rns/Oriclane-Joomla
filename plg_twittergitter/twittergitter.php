<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentTwitterGitter extends JPlugin
{
	
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		/*
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'twittergitte') === false) {
			return true;
		}
		*/		
		
		// expression to search for	(using non greedy ?)
		$regex = '/{twittergitter\s+(.*?)}/i';	
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
		JHTML::_('stylesheet', 'tweeter.css', $assets.'css/');
		JHTML::_('script', 'moohelper.tweeter.js', $assets.'js/');		
	}
	
	function process( &$row, &$match )
	{
		$content ='';
		
		if (preg_match('/usernames="(.*?)"/', $match[1], $value)) {
			$str = preg_replace('/\s*/', '', $value[1]);
			$usernames=explode(',', $str);	
		
			$names = array();
			foreach ($usernames as $username) $names[] = "'".$username."'";

			$document	= & JFactory::getDocument();
			$script = "\t".'var tweet_usernames = ['.implode($names,', ').'];'."\n";
			$document->addScriptDeclaration($script);
			
			$content	= '<div id="tweets-here"></div>'."\n";
		}	
			
		if (preg_match('/username="(.*?)"/', $match[1], $value)) {
			$username=$value[1];	
		
			$document	= & JFactory::getDocument();
			$script = "\t".'var tweet_username = '."'".$username."'".';'."\n";
			$document->addScriptDeclaration($script);
			
			$content	= '<div id="tweet-one"></div>'."\n";
		}
		
		if (preg_match('/random="(.*?)"/', $match[1], $value)) {
			$str = preg_replace('/\s*/', '', $value[1]);
			$usernames=explode(',', $str);	
		
			$rand_keys = array_rand($usernames, 1);
			$username =$usernames[$rand_keys];

			$document	= & JFactory::getDocument();
			$script = "\t".'var tweet_username = '."'".$username."'".';'."\n";
			$document->addScriptDeclaration($script);
			
			$content	= '<div id="tweet-one"></div>'."\n";
		}		
					
		$row->text 	= str_replace($match[0], $content, $row->text );
	}
}
