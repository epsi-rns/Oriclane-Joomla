<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');
jimport('joomla.html.parameter');

/**
* Plugin that loads module positions within contentz
*/
class plgContentAccordion extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
        $searchtag = '{accordion}';

        if(strpos($article->text, $searchtag) !== false) {
			$assets = JURI::base() . 'media/libraries/';
 		
			//	Add CSS, oops don't forget JS....		
			JHTML::_('behavior.mootools');
			JHTML::_('stylesheet', 'css/accordion.css', $assets);
			JHTML::_('script', 'js/moohelper.accordion.js', $assets);		
        }

        $article->text = str_replace($searchtag, '', $article->text);
	}
}
