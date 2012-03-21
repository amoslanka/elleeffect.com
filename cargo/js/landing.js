;(function($){

  if (window.Elleeffect) return;
  window.Elleeffect = {};

  // Determine the pages and put the class in the body.
  // if ($(''))

  // Cargo events:
  // projectReady >> after project has loaded
  
  console.log("INIT!")

  $(document).bind("projectReady", function(a,b,c){
    console.log("project loaded!", a, b, c);
  });

  



  // Dom manipulation
  $('#content_container').after($('#header'));

  $.fn.vCenter = function() {
  	return this.each(function(i){
  		var h = $(this).height();
  		var oh = $(this).outerHeight();
  		var mt = (h + (oh - h)) / 2;
  		$(this).css("margin-top", "-" + mt + "px");
  		$(this).css("top", "50%");
  		$(this).css("position", "absolute");	
  	});	
  };
  $('.landing_title').vCenter();
  
})(jQuery);
