<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentNoobSimple extends JPlugin
{
   /**
    * Constructor
    *
    * For php4 compatibility !!!
    */
    function plgContentNoobSimple ( &$subject, $config )
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
        if (strpos($article->text, 'noobsimple') === false) {
            return true;
        }

        // initialize variables
        $this->js = array();
        $this->path_js = JURI::base().'media/user/js/';
        $this->path_images = JURI::base().'media/user/images/';

        // expression to search for (using non greedy ?)
        $regex = '/{noobsimple\s+(.*?)}/i';
        $matches    = array();

        // Get plugin info
        /* script removed.. */

        // check whether plugin has been unpublished
        /* script removed.. won't get called */

        // find all instances of plugin and put in $matches
        preg_match_all( $regex, $article->text, $matches, PREG_SET_ORDER );

        // Number of plugins
        if ( count( $matches ) ) $this->initAssets();

        // plugin only processes if there are any instances of the plugin in the text
        foreach($matches as $key => $match)
            $this->process( $article, $match, $key);

        // removes tags without matching module positions
        $row->text = preg_replace( $regex, '', $article->text );

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

        $assets = JURI::base() .'media/libraries/';
        JHTML::_('stylesheet', 'noobsimple.css', $assets.'css/');
        JHTML::_('script', 'moohelper.noobsimple.js', $assets.'js/');
    }

    function process( &$row, $match, $key )
    {
        if (preg_match('/div_id="(.*?)"/', $match[1], $value))
            $key = $value[1];

        if (preg_match('/source="(.*?)"/', $match[1], $value))
            JHTML::_('script', $value[1], $this->path_js);

        if (preg_match('/jsvar="(.*?)"/', $match[1], $value))
            $jsvar = $value[1];

        $size=104;
        if (preg_match('/size="(.*?)"/', $match[1], $value))
            $size = $value[1];

        $path = '';
        if (preg_match('/path="(.*?)"/', $match[1], $value))
            $path = $value[1].'/';
        $path = $this->path_images.$path;

        $div_id = 'noobsimplebox_'.$key;

        $noob   = '
    <div class="noob_simple_mask">
        <div id="'.$div_id.'"></div>
    </div>'."\n";
        $row->text  = str_replace($match[0], $noob, $row->text );

        $this->js[] = "mooNoobSimpleHelper($size, $jsvar, '$path', '$div_id');";
    }
}
