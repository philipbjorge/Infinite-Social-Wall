Infinite-Social-Wall
====================
###An infinite social stream based on RSS feeds with a MySQL backend.
####Hosted Version Coming Soon - [infinitesocialwall.appspot.com](http://infinitesocialwall.appspot.com)

![ISW Demo](http://i.imgur.com/pbmEG.jpg)

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
##Detailed instructions can be found on the [wiki](https://github.com/philipbjorge/Infinite-Social-Wall/wiki/Detailed-Installation).
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

###Your Page
The file demo.php provides a good minimal example of the requirements.

###Customizing CSS
1. Customizing of the actual content boxes can be found in isotope.css
2. Customizing of specific feed themes can be found in networks.css. Class names are assigned to content boxes based on the key in your $apis variable in config.php

##Changelog
Beta2 Maintenance (10.8.2012)
* Improved URL auto linking
* Improved default image resolution display

Beta2 (7.29.2012)
* Updated demo.php to include all necessary markup.
* Added loader to infinite scroll.
* Trimmed down README and moved to wiki.
* Cleaned up infinitesocialwall javascript.
* Added minified version.

Beta (7.15.2012)

* Refactored PHP code into one file (and config/libs) for ease of distribution.
* Added HTML5 Shiv for IE support.
* Documented adding new services.
* Updated infinite scroll.
* Hiding new elements and fading them in (with jquery fallback).
* Added a license.

Alpha (6.17.2012)

* Initial implementation.

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
