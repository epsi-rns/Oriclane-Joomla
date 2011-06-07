<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentHome extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'home') === false) {
			return true;
		}	

		// expression to search for	(using non greedy ?)
		$regex = '/{home}/i';		
		
	 	// find all instances of plugin and put in $matches
		preg_match_all( $regex, $article->text, $matches, PREG_SET_ORDER );

 		// removes tags without matching module positions
		$article->text = preg_replace( $regex, JURI::base(), $article->text );		
	}
}
