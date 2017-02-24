$(document).ready(function() {
	$('select').material_select();

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

	$('.back').click(function() {
		back();
		return false;
	});
});

var back = function() {
	history.back();
}