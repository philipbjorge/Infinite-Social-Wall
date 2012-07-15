// Infinite Social Wall
// 7.15.2012
//
// Philip Bjorge
// https://github.com/philipbjorge/Infinite-Social-Wall
// Dual MIT/BSD License
// http://modernizr.com/license/
//
//
(function($){
      var $container = $('#social-container');
	  var cssTransitionsSupported = false;
	  (function() {
		// http://heydanno.com/blog/2010/02/08/detecting-css-transitions-support-using-javascript/
		var div = document.createElement('div');
		div.setAttribute('style', 'transition:top 1s ease;-webkit-transition:top 1s ease;-moz-transition:top 1s ease; -o-transition: top 1s ease');
		cssTransitionsSupported = !!(div.style.transition || div.style.webkitTransition || div.style.MozTransition || div.style.OTransition);
		delete div;
	  })();
    
      $container.isotope({
        itemSelector : '.social-item',
		animationEngine : 'best-available',
        animationOptions : {
            duration: 750,
            easing: 'linear',
            queue: true
        },
		getSortData: {
			time: function( $elem ) {
				return $elem.find('time').attr('datetime');
			}
		},
		sortBy: 'time',
		sortAscending: false
      });
	  
	  $("#new-content").load('get_stream.php?p=update', function() {
		$container.isotope('insert', $(this).children('.social-item'));
		$("time").timeago();
	  });
	  
	  if ($("time").length)
		$("time").timeago();
      
      $container.infinitescroll({
        navSelector  : '#social-nav',    // selector for the paged navigation 
        nextSelector : '#social-nav a',  // selector for the NEXT link (to page 2)
        itemSelector : '.social-item'    // selector for all items you'll retrieve
        },
        function( newElements ) {
			var $newElems = $( newElements ).css({ opacity: 0 });
			$newElems.imagesLoaded(function(){
				$("time").timeago();
				$container.isotope('appended', $newElems );
				if (cssTransitionsSupported)
					$newElems.css({ opacity: 1 });
				else
					$newElems.animate({opacity: 1.0}, 750);
			});
        }
      );
})(jQuery);