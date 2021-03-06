// http://davidwalsh.name/js/twittergitter
// http://davidwalsh.name/mootools-twitter-plugin

/*
    Plugin:     TwitterGitter
    Author:     David Walsh
    Website:    http://davidwalsh.name
    Date:       2/21/2009

    Note:       Modified by epsi, 2 nov 2009
    Note:       Modified by epsi, 13 jan 2013
*/

var TwitterGitter = new Class({

    //implements
    Implements: [Options,Events],

    //options
    options: {
        count: 2,
        sinceID: 1,
        link: true,
        onRequest: $empty,
        onComplete: $empty
    },

    //initialization
    initialize: function(username,options) {
        //set options
        this.setOptions(options);
        this.info = {};
        this.username = username;
    },

    //get it!
    retrieve: function() {
        new Request.JSONP({
            // url: 'http://twitter.com/statuses/user_timeline/' + this.username + '.json',
            url: 'https://api.twitter.com/1/statuses/user_timeline.json?screen_name=' + this.username + '&count=' + this.options.count,
            data: {
                count: this.options.count,
                since_id: this.options.sinceID
            },
            onRequest: this.fireEvent('request'),
            onComplete: function(data) {
                //linkify?
                if(this.options.link) {
                    data.each(function(tweet) { tweet.text = this.linkify(tweet.text); },this);
                }
                //complete!
                this.fireEvent('complete',[data]);
            }.bind(this)
        }).send();
        return this;
    },

    //format
    linkify: function(text) {
        //courtesy of Jeremy Parrish (rrish.org)
        return text
            .replace(/(https?:\/\/\S+)/gi,'<a href="$1">$1</a>')
            .replace(/(^|\s)@(\w+)/g,'$1<a href="http://twitter.com/$2">@$2</a>')
            .replace(/(^|\s)#(\w+)/g,'$1#<a href="http://search.twitter.com/search?q=%23$2">$2</a>');
    }
});


/* epsi additional */
var tweet_usernames = [
    'mootools', 'joomla', 'drupal', 'rails',
    'symfony', 'cakephp', 'codeigniter'];

function show_tweet(tweet, target_id)
{
    a_href = '<a href="https://twitter.com/'
        + tweet.user.screen_name + '" target="_blank">';

    username = '<strong>' + tweet.user.name + '</strong>';
    username = a_href + username + '</a>';

    image_url = tweet.user.profile_image_url.replace("\\",'');
    image = '<img src="' + image_url + '" align="left" alt="'
        + tweet.user.name + '" /> ';
    image = a_href + image + '</a>';

    source = '<span>' + tweet.created_at
            + ' via ' + tweet.source.replace("\\",'') + '</span>';

    new Element('div',{
        html: image
            + username + '<br />'
            + tweet.text + '<br />'
            + source,
        'class': 'tweet'
    }).inject(target_id);
}

// inpired by:
// http://www.pushingbuttons.net/?ArrayinsensitiveSort_in_MooTools
Array.implement({
    tweetSort: function() {
        var tweets=this, result = [], tmp = [], tmpHash = $H();
        tweets.each(function(item, i) {
            var key = Date.parse(item.created_at).toISOString();
            tmp.push(key);
            tmpHash.include(i, key);
        });
        tmp = tmp.sort();
        tmp.reverse();
        tmp.each(function(val) {
            result.push(tweets[tmpHash.keyOf(val)]);
        });
        return result;
    }
});

function noob_tweets(tweets)
{
    var items2 = [];
    var count = tweets.length;
    for ( i=0; i < count; i++ ) items2[i] = i;

    if (count>0) {
        mask_el = document.id('noob_tweets_mask');
        mask_el.setStyle('height','70px');

        var tweetSlide = new noobSlide({
            box: tweet_el,
            mode: 'vertical',
            items: items2,
            size: 68,
            autoPlay: true,
            interval: 5000, // do not waste browser CPU !!!
            fxOptions: {
                duration: 1000,
                transition: Fx.Transitions.Bounce.easeOut,
                wait: false
            }
        });
    }
}


// modification from davidwalsh
/* usage */
window.addEvent('domready',function() {
    // simply one tweet
    tweet_el = document.id('tweet-one');
    if (tweet_el!=null) {
        //get information
        new TwitterGitter(tweet_username, {
            count: 1,
            onComplete: function(tweets) {
                tweet_el.set('html','');
                tweets.each(function(tweet,i) {
                    show_tweet(tweet, 'tweet-one'); });
            }
        }).retrieve();
    }

    // multiple tweets
    tweets_el = document.id('tweets-here');
    if (tweets_el!=null) {
        var tweets_array = [];

        tweet_usernames.each(function(username) {
            //get information
            var myTwitterGitter = new TwitterGitter(username, {
                count: 5,
                onComplete: function(tweets) {
                    tweets_el.set('html','');
                    tweets_array.combine(tweets);
                    tweets_array = tweets_array.tweetSort();
                    tweets_array.each(function(tweet,i) {
                        show_tweet(tweet, 'tweets-here'); });
                }
            }).retrieve();
        });
    }

    // multiple tweets from single user account
    tweet_el = document.id('tweets-one-roll');
    if (tweet_el!=null) {
        var tweeties = [];

        //get information
        new TwitterGitter(tweet_username, {
            count: 5,
            onComplete: function(tweets) {
                tweet_el.set('html','');
                tweets.each(function(tweet,i) {
                    show_tweet(tweet, 'tweets-one-roll'); });
                noob_tweets(tweets);
            }
        }).retrieve();
    }

});
