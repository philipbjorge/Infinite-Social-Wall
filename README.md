Infinite-Social-Wall
====================
###An infinite social stream based on RSS feeds with a MySQL backend.

A video demonstrating the functionality (unfortunately not showing the beautiful CSS3 transitions) can be seen on [youtube][video]. As well as on my personal homepage [philipbjorge.com][mysite].

##Officially Supported Networks (Icons/Styles included)
Currently supports the following social networks (however it should work reasonably well with any RSS feed):

 * Google Plus
 * Github
 * Pinterest
 * Twitter
 * Stackoverflow
 * Reddit
 * Instagram

##Installation
###Database + Server
Create a database (or use an existing one).

Create the archive table.

    CREATE TABLE `archived_social_items` (
        `id` varchar(32) NOT NULL,
        `category` varchar(255) NOT NULL,
        `title` text NOT NULL,
        `content` text NOT NULL,
        `link` text NOT NULL,
        `date` datetime NOT NULL,
        UNIQUE KEY `item_id` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1

Modify config.php's mysql settings to point to your database.

Create and/or chmod the cache folder to be writable by your server (755).

Chmod the config file to 640.

###RSS Feeds
New feeds can be added to the application by modifying the $apis array in config.php

Simply add a new entry to incorporate it in your feed.

    "github" => array(
        "user" => "philipbjorge",
        "url" => "http://atom2rss.semiologic.com/?atom=https://github.com/{USER}.atom"
    ),

The key "github" is used as a CSS identifier. The url is the RSS feed, where {KEY} tags are replaced by the corresponding key in the array. 
So, 

http://atom2rss.semiologic.com/?atom=https://github.com/{USER}.atom 

becomes 

http://atom2rss.semiologic.com/?atom=https://github.com/philipbjorge.atom

###Your Page
The file demo.php provides a good minimal example of the requirements.

In your head, you need HTML5Shiv and the social wall stylesheets.

    <!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <style type="text/css"> .clear { zoom: 1;display: block;} </style> <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/isotope.css">
    <link rel="stylesheet" type="text/css" href="css/networks.css">

In your body, you need the container and PHP include.

    <div id="social-container" class="variable-sizes clearfix infinite-scrolling">
	    <?php require_once('get_stream.php'); ?>
    </div>

Below that, you need the supporting javascript.

    <script src="js/jquery-1.7.1.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/jquery.infinitescroll.min.js"></script>
    <script src="js/jquery.timeago.js" type="text/javascript"></script>
    <script src="js/jquery.infinitesocialwall.js" type="text/javascript"></script>

###Customizing CSS
1. Customizing of the actual content boxes can be found in isotope.css
2. Customizing of specific feed themes can be found in networks.css. Class names are assigned to content boxes based on the key in your $apis variable in config.php

##Changelog
Beta (7.15.2012)

* Refactored PHP code into one file (and config/libs) for ease of distribution.
* Added HTML5 Shiv for IE support.
* Documented adding new services.
* Updated infinite scroll.
* Hiding new elements and fading them in (with jquery fallback).
* Added a license.

Alpha (6.17.2012)

* Initial implementation.

##How it Works
###Overview
When the demo.php page is loaded, the first 20 entries are loaded into our container div (_simulating_ a call to get_stream.php?p=1). Isotope and infinite-scroll are initialized on this container div.

On the page load, an asynchronous request is made to get_stream.php?p=update which queries all the RSS feeds in config.php and adds new entries to the MySQL database. New entries are also output as HTML which are inserted into our isotope container (in time sorted order).

In this way, each page viewer gets the latest social content and is also our "cron job." **Currently, a 15 minute cache on RSS queries is implemented (via SimplePie).**

By utilizing the MySQL database, a history of all your social items is created, allowing nearly limitless scrolling after the app has been installed for a sufficient time (in contrast to other API based methods that can only show the latest social items).

###Details
Content boxes contain:

 * .header div with the RSS items title (if it differs from the content).
 * .content div with the RSS items content.
 * .footer div with an image, the RSS item's link and date.

Links that are not wrapped in anchor tags are wrapped server-side and trimmed. E.g. http://losdfsdfsdfsdfsdfngurl.com would become http://lo...ngurl.com.

##License
Dual licensed under the MIT/BSD licenses.
Text can be found [here][licenses].
	
##Credits
Utilizes the following libraries:

 * [Isotope][isotope] - Free for non-commercial and personal applications ([details...][isotope-license])
 * [Infinite-Scroll][infinite-scroll] - MIT License
 * [jQuery][jquery] - MIT License
 * [SimplePie][simplepie] - BSD License
 * [jquery-timeago][timeago] - MIT License
 * [html5shiv][shiv] - MIT License
 * [css3 transition detection][transition] - Unknown
 
Icons are from [icondock][icons] which were released under the "Free to use for whatever purposes" license.

[isotope]: https://github.com/desandro/isotope
[isotope-license]: http://isotope.metafizzy.co/docs/license.html
[infinite-scroll]: https://github.com/paulirish/infinite-scroll
[jquery]: https://github.com/jquery/jquery
[icons]: http://icondock.com/free/vector-social-media-icons
[simplepie]: https://github.com/simplepie/simplepie/
[timeago]: https://github.com/rmm5t/jquery-timeago
[video]: http://www.youtube.com/watch?v=NTuPJP86ouk
[licenses]: http://modernizr.com/license/
[mysite]: http://www.philipbjorge.com
[shiv]: http://code.google.com/p/html5shiv/
[transition]: http://heydanno.com/blog/2010/02/08/detecting-css-transitions-support-using-javascript/