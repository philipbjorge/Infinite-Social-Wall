<?php

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

function to_html($category, $title, $content, $link, $date) {
	$r = <<<OUTPUT
	<div class="social-item {$category}" data-category="{$category}">
      <div class="content">{$content}</div>
	  <div class="footer"><img src="images/{$category}.png" />Shared <time datetime="{$date}" pubdate>{$date}</time></div>
    </div>
OUTPUT;
	
	return $r;
}

?>