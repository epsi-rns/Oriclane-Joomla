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

        // expression to search for (using non greedy ?)
        $regex = '/{twittergitter\s+(.*?)}/i';
        $matches    = array();

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

    private function initAssets()
    {
        $assets = JURI::base() .'media/libraries/';
        JHTML::_('stylesheet', 'tweeter.css', $assets.'css/');
        JHTML::_('script', 'moohelper.tweeter.js', $assets.'js/');

        // Include javascript and stylesheet
        JHTML::_('moolib.noobslide');
        JHTML::_('stylesheet', 'noobsimple.css', $assets.'css/');
        JHTML::_('script', 'moohelper.noobsimple.js', $assets.'js/');
    }

    private function getSamples()
    {
        return array(
            'univ_indonesia', 'UI_library', 'KampusUpdate',
            'UIUpdate', 'InfoUI', 'anakuidotcom', 'simak_ui', 'IluniUI',
            'humasftui', 'ILUNIFT', 'KedokteranUI', 'SKMAesculapius',
            'mediacenterFEUI', 'fisip_ui',
            'PemiraUI', 'DPM_UI', 'BEMUI_2012',
            'BEMUI_Care', 'BEMUI_Change', 'BEMUI_Adkesma',
            'BEMFFUI', 'BEMPsikoUI', 'BEMFIBUI', 'BEM_FHUI', 'BEMVokasi_UI',
            'bemFMIPAUI', 'BEMFasilkomUI', 'BemFTUI', 'BEMFEUI', 'BEMFIKUI',
            'BEMFKGUI', 'BEMIKMFKUI', 'bemfisipui', 'STUNICAFMUI',
            'HMIKUI', 'HMSosioUI', 'hmipui', 'hmhiui', 'hmadmfisipui',
            'HMIKSFISIPUI', 'HeMAnUI', 'HIMAKRIM', 'fisipersui',
            'DansaUI', 'SumaUI', 'madahbahana', 'UIEquestrian',
            'rtcuifm', 'oim_ui', 'UItoPIMNAS', 'wiramudaUI',
            'RumbaFISIPUI', 'BintangMakara', 'HOCKEYUI', 'Cabotage_ID',
            'IMS_FTUI', 'imm_ftui', 'IMEFTUI', 'immt_ftui', 'IMA_FTUI',
            'imtk_ftui', 'imti_ftui', 'IMPI_FTUI', 'kapainfo',
            'SIWAinfo', 'HTW_UI', 'UIRoboticsTeam',
            'IKSEDA_UI', 'IKABSIS', 'IKSIUI', 'SKSUI', 'imasip_ui',
            'kamafibui', 'KOMAFILUI',
            'HMDFISIKAUI', 'hmdGEOUI', 'hmdkimiaui', 'HMDMathUI',
            'himbioui2012', 'UKORMIPAUI',
            'KOPMAFHUI', 'PerfilmaFHUI', 'alsalcui', 'lk2fhui', 'SERAMBIFHUI',
            'BLSFHUI', 'lawperformers', 'RechtstudChoir',
            'SoscomFEUI', 'MSSFEUI', 'VokasinemaUI',
            'JGTCfestival', 'FesbudUI', 'SECONDFEUI', 'ICMSSFEUI', 'UIdeaFest',
            'mechfair2013', 'FTT2013'
        );
    }

    private function process( &$row, &$match )
    {
        $content ='';

        $samples = $this->getSamples();

        if (preg_match('/usernames="(.*?)"/', $match[1], $value)) {
            $str = preg_replace('/\s*/', '', $value[1]);
            $usernames=explode(',', $str);

            $names = array();
            foreach ($usernames as $username) $names[] = "'".$username."'";

            $document   = & JFactory::getDocument();
            $script = "\t".'var tweet_usernames = ['.implode($names,', ').'];'."\n";
            $document->addScriptDeclaration($script);

            $content    = '<div id="tweets-here"></div>'."\n";
        }

        if (preg_match('/username="(.*?)"/', $match[1], $value)) {
            $username=$value[1];

            $document   = & JFactory::getDocument();
            $script = "\t".'var tweet_username = '."'".$username."'".';'."\n";
            $document->addScriptDeclaration($script);

            $content    = '<div id="tweet-one"></div>'."\n";
        }

        if (preg_match('/random="(.*?)"/', $match[1], $value)) {
            $str = preg_replace('/\s*/', '', $value[1]);
            $usernames=explode(',', $str);

            $rand_keys = array_rand($usernames, 1);
            $username =$usernames[$rand_keys];

            $document   = & JFactory::getDocument();
            $script = "\t".'var tweet_username = '."'".$username."'".';'."\n";
            $document->addScriptDeclaration($script);

            $content    = '<div id="tweet-one"></div>'."\n";
        }

        if (preg_match('/auto/', $match[1], $value)) {
            $usernames = $samples;
            $random = array_rand($usernames);

            $username=$usernames[$random] ;

            $document   = & JFactory::getDocument();
            $script = "\t".'var tweet_username = '."'".$username."'".';'."\n";
            $document->addScriptDeclaration($script);

            $content    = '<div id="tweets-one-roll"></div>';
            $content    = '<div id="noob_tweets_mask">'.$content.'</div>'."\n";
        }

        if (preg_match('/autos/', $match[1], $value)) {
            $usernames = $samples;
            $randoms = array_rand($usernames, 7);

            $names = array();
            foreach ($randoms as $random) $names[] = "'".$usernames[$random]."'";

            $document   = & JFactory::getDocument();
            $script = "\t".'var tweet_usernames = ['.implode($names,', ').'];'."\n";
            $document->addScriptDeclaration($script);

            $content    = '<div id="tweets-here"></div>'."\n";
        }

        $row->text  = str_replace($match[0], $content, $row->text );
    }
}
