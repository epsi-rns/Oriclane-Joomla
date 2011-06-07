<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgSystemSharedAssets extends JPlugin
{
    function __construct ( &$subject, $config )
	{
		parent::__construct( $subject, $config );
		
		// Include custom JHTML helpers:
		$path = JPATH_BASE.DS.'plugins'.DS.'system'.DS.'sharedassets'.DS.'html';
		JHTML::addIncludePath( array($path) );
	}
}
