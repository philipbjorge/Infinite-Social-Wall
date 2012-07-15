<html>
<head>
<!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <style type="text/css"> .clear { zoom: 1;display: block;} </style> <![endif]-->
<style type="text/css">
body {
  font-family: Verdana;
  background: #e5e5e5; /* Old browsers */
  background: -moz-linear-gradient(top,  #e5e5e5 0%, #ffffff 100%); /* FF3.6+ */
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e5e5e5), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top,  #e5e5e5 0%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(top,  #e5e5e5 0%,#ffffff 100%); /* Opera 11.10+ */
  background: -ms-linear-gradient(top,  #e5e5e5 0%,#ffffff 100%); /* IE10+ */
  background: linear-gradient(to bottom,  #e5e5e5 0%,#ffffff 100%); /* W3C */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e5e5', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
#social-container {
  width: 50%;
  font-size: 13px;
}
</style>
<link rel="stylesheet" type="text/css" href="css/isotope.css">
<link rel="stylesheet" type="text/css" href="css/networks.css">
</head>
<body>
  <div id="social-container" class="variable-sizes clearfix infinite-scrolling">
	<?php require_once('get_stream.php'); ?>
  </div>
  
  <script src="js/jquery-1.7.1.min.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/jquery.infinitescroll.min.js"></script>
  <script src="js/jquery.timeago.js" type="text/javascript"></script>
  <script src="js/jquery.infinitesocialwall.js" type="text/javascript"></script>
</body>
</html>