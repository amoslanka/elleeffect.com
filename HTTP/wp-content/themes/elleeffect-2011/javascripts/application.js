(function ($) {
	// VERTICALLY ALIGN FUNCTION
	$.fn.vAlign = function() {
		return this.each(function(i){
		var ah = $(this).height();
		var ph = $(this).parent().height();
		var mh = (ph - ah) / 2;
		$(this).css('margin-top', mh);
		});
	};
})(jQuery);

$(document).ready(function() {
	
	// Apply a full size bg to the document if there is one assigned to the body.
	var bg = $('body').css('background-image').replace(/^url|[\(\)]/g, '');
	$('body').css('background-image', 'none');
	$.backstretch(bg, {speed: 800});
	
	
	// On info-page pages, h and v center the post. (does it on page resize, in case the page does resize)
	$('body').resize(function(event) {
		var w = parseInt($('.post').css('position', 'absolute').width(), 10);
		$('.post').css('position', 'relative').width(w + 10).vAlign();
	}).resize();
	
});
