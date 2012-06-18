<?php

function clean_stristr($title, $content) {
	// Strips out tags (after converting special chars), whitespace and trailing ellipses (...s).
	$title = trim(preg_replace('/\s+/', '', strip_tags(htmlspecialchars_decode($title, ENT_QUOTES))), ".");
	$content = trim(preg_replace('/\s+/', '', strip_tags(htmlspecialchars_decode($content, ENT_QUOTES))), ".");
	return mb_stristr($content, $title) !== FALSE;
}

function to_html($category, $title, $content, $link, $date) {
    if (clean_stristr($title, $content))
		$title = "";
	else
		$title = "<div class=\"header\">{$title}</div>";
		
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