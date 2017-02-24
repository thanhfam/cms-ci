$(document).ready(function() {
	$('.filter').click(function() {
		if (!$(this).parent().children('input:first-child').val()) {
			return false;
		}
	});

	$('.unfilter').click(function() {
		if (!$(this).parent().children('input:first-child').val()) {
			return false;
		}
		else {
			$(this).parent().children('input:first-child').val('');
		}
	});
});

var back = function() {
	history.back();
}