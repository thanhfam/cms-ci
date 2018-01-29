<?php
	if (!empty(($item[$media .'_id'])) && gettype($item[$media .'_id']) == 'string') {
		$item[$media .'_id'] = [$item[$media .'_id']];
		$item[$media .'_url'] = [$item[$media .'_url']];
		$item[$media .'_type'] = [$item[$media .'_type']];
		$item[$media .'_file_ext'] = [$item[$media .'_file_ext']];
	}
?>

<script>
var media_id = <?=json_encode($item[$media .'_id']) ?>;
var media_url = <?=json_encode($item[$media .'_url']) ?>;
var media_type = <?=json_encode($item[$media .'_type']) ?>;
var media_file_ext = <?=json_encode($item[$media .'_file_ext']) ?>;

var list = [];

if (media_id && typeof(media_id) == 'object') {
	media_id.forEach(function(item, index) {
		list[index] = {};
		list[index].id = parseInt(item);
	});

	media_url.forEach(function(item, index) {
		list[index].url = item;
	});

	media_type.forEach(function(item, index) {
		list[index].type = item;
	});

	media_file_ext.forEach(function(item, index) {
		list[index].file_ext = item;
	});

	show_no_media("#<?=$media?>");

	if (list.length) {
		show_media({list: list}, "#<?=$media?>");
	}
}
else {
	show_no_media("#<?=$media?>");
}
</script>

