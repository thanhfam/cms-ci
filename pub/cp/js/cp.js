$(document).ready(function() {
	$('#loader').hide();

	if (typeof notification != 'undefined') {
		UIkit.notification(notification);
	}

	$('button.filter').click(function() {
		if (!$(this).parent().find('input.keyword').val()) {
			return false;
		}
	});

	$('button.unfilter').click(function() {
		if ($(this).parent().find('input.keyword').val()) {
			$(this).parent().find('input.keyword').val('');
		}
		else {
			return false;
		}
	});

	$('[name=btn-back]').click(function(e) {
		if (!$(this).attr('href')) {
			back();
			return false;
		}
		
	});

	$('a.btn-remove').click(function(e) {
		e.preventDefault();
		var msg = $(this).attr('data-msg');
		var url = $(this).attr('href');

		UIkit.modal.confirm(msg).then(function() {
			window.location = url;
		}, function () {
		});
	});
});

var back = function() {
	history.back();
}

var loader = {
	show: function() {
		$('#loader').show();
	},
	hide: function() {
		$('#loader').hide();
	}
};

var get_district = function(e) {
	var d_selector = $('#district-selector');
	var c_id = (e.options[e.selectedIndex].value);

	if (!d_selector.length || !c_id) {
		return false;
	}

	$.ajax({
		url: base_url + 'cp/district/select/',
		dataType: 'json',
		data: {
			id: c_id
		},
		beforeSend: function(jqXHR, settings) {
			loader.show();
		},
		complete: function(jqXHR, textStatus) {
			loader.hide();
		},
		success: function(data, textStatus, jqXHR) {
			d_selector.children('[value]').remove();

			if (data.length) {
				var items = [];

				for (var i = 0, len = data.length; i < len; i++) {
					items.push('<option value="' + data[i].id + '">' + data[i].title + '</option>');
				}

				d_selector.append(items.join(''));
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
		}
	})
};

var get_ward = function(e) {
	var w_selector = $('#ward-selector');
	var d_id = (e.options[e.selectedIndex].value);

	if (!w_selector.length || !d_id) {
		return false;
	}

	$.ajax({
		url: base_url + 'cp/ward/select/',
		dataType: 'json',
		data: {
			id: d_id
		},
		beforeSend: function(jqXHR, settings) {
			loader.show();
		},
		complete: function(jqXHR, textStatus) {
			loader.hide();
		},
		success: function(data, textStatus, jqXHR) {
			w_selector.children('[value]').remove();

			if (data.length) {
				var items = [];

				for (var i = 0, len = data.length; i < len; i++) {
					items.push('<option value="' + data[i].id + '">' + data[i].title + '</option>');
				}

				w_selector.append(items.join(''));
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
		}
	})
};