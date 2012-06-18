<?php
require('config.php');
require('helpers.php');
  
// Pagination variable.
if (!isset($_GET['p']))
	$p = 1;
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