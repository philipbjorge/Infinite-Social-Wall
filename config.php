<?php
// Infinite Social Wall
// 7.29.2012
//
// Philip Bjorge
// https://github.com/philipbjorge/Infinite-Social-Wall
// Dual MIT/BSD License
// http://modernizr.com/license/
//
//

//
// MODIFIABLE SETTINGS
//

// MySQL Settings
$mysql_server = "localhost";
$mysql_user = "root";
$mysql_pass = "root";
$mysql_db = "infinite_social_wall";
$mysql_table = "archived_social_items";

// "Pagination" settings - how many social items to output on each load
$results_per_page = 20;

// RSS Feeds ("APIs")
// the url key points to your RSS feed.
// uppercase keywords like {USER} are replaced by the lowercase
// key in the corresponding array.
// e.g. "http://gplus-to-rss.appspot.com/rss/{USER}" becomes "http://gplus-to-rss.appspot.com/rss/111577025166114857734"
$apis = array(
	"google-plus" => array(
		"user" => "111577025166114857734",
		"url" => "http://gplus-to-rss.appspot.com/rss/{USER}"
	),
	"github" => array(
		"user" => "philipbjorge",
		"url" => "http://atom2rss.semiologic.com/?atom=https://github.com/{USER}.atom"
	),
	"pinterest" => array(
		"user" => "philipbjorge",
		"url" => "http://pinterest.com/{USER}/feed.rss"
	),
	"twitter" => array(
		"user" => "philipbjorge",
		"url" => "http://twitter.com/statuses/user_timeline/{USER}.rss"
	),
	"stackoverflow" => array(
		"user" => "1139340",
		"url" => "http://stackoverflow.com/feeds/user/{USER}"
	),
	"reddit" => array(
		"user" => "philipbjorge",
		"url" => "http://www.reddit.com/user/{USER}/.rss"
	),
	"instagram" => array(
		"user" => "philipbjorge",
		"url" => "http://statigr.am/feed/{USER}"
	)
);

//
// END MODIFIABLE SETTINGS
//

// MySQL Connection
$mysqli = new mysqli($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
?>