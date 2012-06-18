<?php

require_once('config.php');
require_once('helpers.php');
require_once('lib/simplepie.inc');

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

?>