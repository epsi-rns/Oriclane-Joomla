<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');
jimport( 'joomla.html.parameter' );

/**
* Plugin that loads module positions within contentz
*/
class plgContentNoobSlide extends JPlugin
{
    function __construct ( &$subject, $config )
	{
		parent::__construct( $subject, $config );
		$this->checkDependency();
	}	
	
	function checkDependency()
	{	
		$plugin =& JPluginHelper::getPlugin('system', 'sharedassets');        
		if ( empty($plugin)) {
			$app = &JFactory::getApplication();
			$msg = 'You should activate sharedassets plugin '
			.'to get this plugin work properly.';
			$app->enqueueMessage($msg);
		} 				
	}

	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'noobslide') === false) {
			return true;
		}	
		
		// initialize variables
		$this->path_js = JURI::base().'media/user/js/';		
		$this->js = array();		
		
		// expression to search for	(using non greedy ?)
		$regex = '/{noobslide\s+(.*?)}/i';
		$matches	= array();	
		
		// Get plugin info 		
 		$this->lightbox_type = $this->params->get('lightbox_type');

		// check whether plugin has been unpublished
		/* script removed.. won't get called */

	 	// find all instances of plugin and put in $matches
		preg_match_all( $regex, $article->text, $matches, PREG_SET_ORDER );

 		// Number of plugins
 		if ( count( $matches ) ) $this->initAssets();

 		// plugin only processes if there are any instances of the plugin in the text		
		foreach($matches as $match)
 			$this->process( $article, $match);
		
  		// removes tags without matching module positions
		$article->text = preg_replace( $regex, '', $article->text );
		
		if(!empty($this->js)) {
			$js = '
	<script type="text/javascript">
	window.addEvent("domready",function(){		
		'.implode($this->js, "\n\t\t").'
	});
	</script>
';
			$article->text = $js.$article->text;
		}
	}
	
	function initAssets()
	{
		// Include javascript and stylesheet
		JHTML::_('moolib.noobslide');
		JHTML::_('moolib.reflection');	
		
		switch($this->params->get('lightbox_type')) {
		case 1: // you should install my version of plg_slimbox in order to run
			$box_assets = 'media/libraries/slimbox/';
			JHTML::_('stylesheet', 'slimbox.css', $box_assets);
			JHTML::_('script', 'slimbox.mootools.122.js', $box_assets);	
			break;
		case 2: // you should install my version of plg_mediabox in order to run
			$box_assets = 'media/libraries/mediabox/';
			JHTML::_('stylesheet', 'mediaboxAdvBlack21.css', $box_assets);
			JHTML::_('script', 'mediaboxAdv-1.4.6.js', $box_assets);	
			break;
		}				
			
		$assets = JURI::base() .'media/libraries/';
		JHTML::_('stylesheet', 'noob.css', $assets.'css/');
		JHTML::_('script', 'moohelper.noob.js', $assets.'js/');		
	}	
	
	
	function initAssetsHorz()
	{
		$document	= & JFactory::getDocument();	
		$style = '
.noob_mask img {	height:240px;	}';
		$document->addStyleDeclaration($style);
	}
	
	
	function process( &$row, &$match )
	{
		//	box=true
		if (preg_match('/box="(.*?)"/', $match[1], $value)) 
			$this->initAssetsHorz();
		
		// picasa mode	
		$picasa_user ='';	
		if (preg_match('/picasa_user="(.*?)"/', $match[1], $value)) 
			$picasa_user = $value[1];
		
		$picasa_album ='';	
		if (preg_match('/picasa_album="(.*?)"/', $match[1], $value)) 
			$picasa_album = $value[1];	
		
		$picasa_link = 'http://picasaweb.google.com/'.$picasa_user.'/'.$picasa_album;
		
		$adapter=(int)(empty($picasa_user) || empty($picasa_album));	
		if ($adapter==0)	// default is picasa
			JHTML::_('script', 'mooclass.gpw.js', 'media/libraries/js/');
						
		// otherwise file mode			
		if (preg_match('/source="(.*?)"/', $match[1], $value)) 
			JHTML::_('script', $value[1], $this->path_js);
			
		// info
		$title ='';
		if (preg_match('/title="(.*?)"/', $match[1], $value)) 
			$title = $value[1];
			
		$subtitle ='';	
		if (preg_match('/subtitle="(.*?)"/', $match[1], $value)) 
			$subtitle = $value[1];	

		ob_start();
		include('noobslide.tmpl.php');		
		$outputbuffer = ob_get_contents();
		ob_end_clean();		
			
		$row->text 	= str_replace($match[0], $outputbuffer, $row->text );
		
		$this->js[] = '';
	}
}
