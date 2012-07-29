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
require_once('config.php');
require_once('lib/simplepie.inc');

// ************************************************
//
//   HELPERS
//
// ************************************************
function replace_api_keywords($apis) {
	$urls = array();
	$categories = array();
	foreach ($apis as $cat => $api) {
		$url = $api['url'];
		// Replace our {XXX} variables in our URL strings
		foreach ($api as $replacement_key => $replacement) {
			if ($replacement_key != 'url') {
				$replacement_key = strtoupper($replacement_key);
				$url = str_replace("{{$replacement_key}}", $replacement, $url);
			}
		}
		$categories[$url] = $cat;
		$urls[] = $url;
	}
	return array($urls, $categories);
}

function regexp_url_search($r) {
	// Modified from http://www.bytemycode.com/snippets/snippet/602/
	$maxurl_len = 35;
	$url = $r[0];
	$offset1 = ceil(0.65 * $maxurl_len) - 2;
	$offset2 = ceil(0.30 * $maxurl_len) - 1;    
	if ($maxurl_len AND strlen($url) > $maxurl_len)
		$urltext = substr($url, 0, $offset1) . '...' . substr($url, -$offset2);
	else
		$urltext = $url;		
	$text = '<a href="'. $url .'" title="'. $url .'">'. $urltext .'</a>';
	return $text;
}

function autoLinkUrls($text) {
	// Callback preg_replace found on 
	// http://stackoverflow.com/questions/9102003/php-auto-detect-links-and-put-them-into-a-tag-except-when-they-are-already
	$text = preg_replace_callback('#(?<![href|src]\=[\'"])(https?|ftp|file)://[-A-Za-z0-9+&@\#/%()?=~_|$!:,.;]*[-A-Za-z0-9+&@\#/%()=~_|$]#', 'regexp_url_search', $text);
	return $text;
}

function clean_stristr($title, $content) {
	// Strips out tags (after converting special chars), whitespace and trailing ellipses (...s).
	$title = trim(preg_replace('/\s+/', '', strip_tags(htmlspecialchars_decode($title, ENT_QUOTES))), ".");
	$content = trim(preg_replace('/\s+/', '', strip_tags(htmlspecialchars_decode($content, ENT_QUOTES))), ".");
	return mb_stristr($content, $title) !== FALSE;
}

function to_html($category, $title, $content, $link, $date) {
	// Set our header div based on a substring comparison of the title/content.
    if (clean_stristr($title, $content))
		$title = "";
	else
		$title = "<div class=\"header\">{$title}</div>";
	
	// Surround links with anchor tags and add ellipses if the URL is "too long."
	// TODO: This should probably be a config option.
	$title = autoLinkUrls($title);
	$content = autoLinkUrls($content);

	$r = <<<OUTPUT
	<div class="social-item {$category}" data-category="{$category}">
	  {$title}
      <div class="content">{$content}</div>
	  <div class="footer"><img src="images/{$category}.png" /><a href="{$link}">Shared</a> <time datetime="{$date}" pubdate>{$date}</time></div>
    </div>
OUTPUT;
	
	return $r;
}


// **************************************************************************
//
//   UPDATE LOGIC
//
// **************************************************************************
function update_DB($apis, $mysqli, $mysql_table) {
	// Creates our url list and our URL => category map.
	list($urls, $categories) = replace_api_keywords($apis);

	// Initialize SimplePie
	$feed = new SimplePie();
	$feed->set_feed_url($urls);
	$feed->set_cache_location('./cache');
	$feed->set_cache_duration(900);	// 15 minute cache
	$feed->init();

	// Initialize a prepared SQL statement for saving our social stream.
	$stmt = $mysqli->prepare("INSERT INTO {$mysql_table} (id, category, title, content, link, date) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('ssssss', $id, $category, $title, $content, $link, $date);

	foreach($feed->get_items() as $item) {
		$id = $item->get_id(true);
		$category = $categories[$item->get_feed()->feed_url];
		$title = $item->get_title();
		$content = $item->get_content();
		$link = $item->get_link();
		$date = $item->get_date("Y-m-d\TH:i:sO");
		
		if ($stmt->execute()) {
			// New Entry, so we render it as html.
			echo to_html($category, $title, $content, $link, $date);
		}
	}

	$mysqli->close();
	exit;
}
 
// **************************************************************************
//
//   GET/PAGE LOGIC
//
// **************************************************************************
 
// Pagination variable.
if (!isset($_GET['p']))
	$p = 1;
else if ($_GET['p'] == "update")
	update_DB($apis, $mysqli, $mysql_table);
else
	$p = filter_input(INPUT_GET, "p", FILTER_VALIDATE_INT);

// Exit if a bad page is supplied.
if ($p === False || $p < 1)
	exit;

$start = ($p-1) * $results_per_page;
$result = $mysqli->query("SELECT * FROM {$mysql_table} ORDER BY date DESC LIMIT {$start}, {$results_per_page}");
  
if ($result) {
	while ($row = $result->fetch_array()) {
		echo to_html($row['category'], $row['title'], $row['content'], $row['link'], date("c", strtotime($row['date'])));
	}
}
  
// Output the next pagination URL
if ($result->num_rows == $results_per_page) {
	$p += 1;
	echo '<nav id="social-nav"><a href="get_stream.php?p='.$p.'"></a></nav>';
}

$result->free();
$mysqli->close();
?>