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

?>