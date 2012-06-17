<html>
<head>
<style type="text/css">
body {
  font-family: Verdana;
  background-image: url(images/old_wall.png);
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
  <div id="new-content"></div>
  
  <script src="js/jquery-1.7.1.min.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/jquery.infinitescroll.min.js"></script>
  <script src="http://timeago.yarp.com/jquery.timeago.js" type="text/javascript"></script>
  <script>
    $(window).load(function(){
      var $container = $('#social-container');
    
      $container.isotope({
        itemSelector : '.social-item',
		animationEngine : 'best-available',
        animationOptions : {
            duration: 750,
            easing: 'linear',
            queue: false
        },
		getSortData: {
			time: function( $elem ) {
				return $elem.find('time').attr('datetime');
			}
		},
		sortBy: 'time',
		sortAscending: false
      });
	  
	  $("#new-content").load('update_stream.php', function() {
		$container.isotope('insert', $(this).children('.social-item'));
		$("time").timeago();
	  });
	  
	  if ($("time").length)
		$("time").timeago();
      
      $container.infinitescroll({
        navSelector  : '#social-nav',    // selector for the paged navigation 
        nextSelector : '#social-nav a',  // selector for the NEXT link (to page 2)
        itemSelector : '.social-item',     // selector for all items you'll retrieve
		bufferPx : 400,
		debug: true,
        loading: {
            finishedMsg: 'No more pages to load.',
            img: 'images/loader.gif'
          }
        },
        // call Isotope as a callback
        function( newElements ) {
			var $newElems = $(newElements);
			$newElems.imagesLoaded(function(){
				$container.isotope('appended', $newElems );
				$("time").timeago();
			});
        }
      );
	  
    });
  </script>
</body>
</html>