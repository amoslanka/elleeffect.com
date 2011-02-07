$(document).ready(function() {
	// easy toggle for categories
	$('#triggerCatID').click(function() {
		$(this).toggleClass('focus');
		$('#headerStrip').animate({ height: 'toggle', opacity: '100'}, 100);
		return false;
	});
	$('#triggerCatID2').click(function() {
		$(this).toggleClass('focus');
		$('#footerStrip').animate({ height: 'toggle', opacity: '100'}, 100);
		return false;
	});
});