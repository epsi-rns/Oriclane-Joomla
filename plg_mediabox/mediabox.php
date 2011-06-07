<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentMediabox extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
        $searchtag = '{mediabox}';

        if(strpos($article->text, $searchtag) !== false) {
			$assets = JURI::base() . 'media/libraries/mediabox/';
 		
			//	Add CSS, oops don't forget JS....		
			JHTML::_('behavior.mootools');
			JHTML::_('stylesheet', 'mediaboxAdvBlack21.css', $assets);
			JHTML::_('script', 'mediaboxAdv-1.4.6.js', $assets);		
        }

        $article->text = str_replace($searchtag, '', $article->text);
	}
}
