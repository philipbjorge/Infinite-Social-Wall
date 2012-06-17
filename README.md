Infinite-Social-Wall
====================
An infinite social stream based on RSS feeds with a MySQL backend.
A video demonstrating the functionality (unfortunately not showing the beautiful CSS3 transitions) can be seen on [youtube][video].

##Supported Networks (Icons/Styles included)
Currently supports the following social networks (however it should work reasonably well with any RSS feed):
 * Google Plus
 * Github
 * Pinterest
 * Twitter
 * Stackoverflow
 * Reddit
 * Instagram

##Status
This is an *alpha* release. In the future, I'll be looking to document everything further and improve the HTML output.
I haven't tested this under mobile browsers either.

##How it Works
When the demo.php page is loaded, the first 20 entries are loaded into our container div (_simulating_ a call to get_stream.php?p=1). Isotope and infinite-scroll are initialized on this container div.
On the page load, a request is made to update_stream.php which queries all the RSS feeds in config.php and adds new entries to the MySQL database. New entries are also output as HTML. These entries are inserted into our isotope container (in time sorted order).
In this way, each page viewer is guarenteed to have the latest social content. If your social stream is hit often enough, no cron job to ping update_stream.php will be necessary. Currently, a 15 minute cache on RSS queries is implemented (via SimplePie).
update_stream.php would also be light enough to call on a timer (in lieu of push notifications).
By utilizing the MySQL database, a history of all your social items is created, allowing nearly limitless scrolling (in comparison to other API based methods).

##Installation
Modify config.php to include your RSS feeds and point to the correct database.

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