<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access

// Import library dependencies
jimport('joomla.event.plugin');

/**
* Plugin that loads module positions within contentz
*/
class plgContentGooglepresentation extends JPlugin
{
    public function onContentPrepare($context, &$article, &$params, $limitstart)
    {
        // simple performance check to determine whether bot should process further
        if (strpos($article->text, 'presentation') === false) {
            return true;
        }

        // expression to search for (using non greedy ?)
        $regex = '/{presentation\s+(.*?)}/i';
        $matches    = array();

        // find all instances of plugin and put in $matches
        preg_match_all( $regex, $article->text, $matches, PREG_SET_ORDER );

        // plugin only processes if there are any instances of the plugin in the text
        foreach($matches as $match)
            $this->process( $article, $match);

        // removes tags without matching module positions
        $article->text = preg_replace( $regex, '', $article->text );
    }

    function process( &$row, &$match )
    {
        $id = null;
        if (preg_match('/id="(.*?)"/', $match[1], $value))
            $id = $value[1];

        $id2 = null;
        if (preg_match('/id2="(.*?)"/', $match[1], $value))
            $id2 = $value[1];

        if (!empty($id))
        {
            $url = 'http://docs.google.com/present/embed?id='.$id;
            $format = '<iframe src="%s" frameborder="0" width="%d" height="%d"></iframe>';

            $size='s';
            if (preg_match('/size="(.*?)"/', $match[1], $value))
                $size = $value[1];

            switch ($size)
            {
                case 'l':   $width = 700; $height =559; break;
                case 'm':   $width = 555; $height =451; break;
                default:    $width = 410; $height =342;
            }

            $content = sprintf($format, $url, $width, $height);
            $row->text  = str_replace($match[0], $content, $row->text );

        }

        if (!empty($id2))
        {
            $url = 'https://docs.google.com/presentation/embed?id='.$id2.'&start=false&loop=false&delayms=3000';
            $format = '<iframe src="%s" frameborder="0" width="480" height="389" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>';

            $content = sprintf($format, $url, $width, $height);
            $row->text  = str_replace($match[0], $content, $row->text );
        }
    }
}
