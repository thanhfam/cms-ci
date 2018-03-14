<?php
if (!empty(($item[$media .'_url_ori'])) && gettype($item[$media .'_url_ori']) == 'string') {
	$item[$media .'_id'] = [$item[$media .'_id']];
	$item[$media .'_url_ori'] = [$item[$media .'_url_ori']];
	$item[$media .'_type'] = [$item[$media .'_type']];
	$item[$media .'_file_ext'] = [$item[$media .'_file_ext']];
}
//else {
//	$item[$media .'_id'] = $item[$media .'_url_ori'] = $item[$media .'_type'] = $item[$media .'_file_ext'] = [];
//}
?>

<script>
var media_id = <?=json_encode($item[$media .'_id']) ?>;
var media_url = <?=json_encode($item[$media .'_url_ori']) ?>;
var media_type = <?=json_encode($item[$media .'_type']) ?>;
var media_file_ext = <?=json_encode($item[$media .'_file_ext']) ?>;

var list = [];

if (media_url && typeof(media_url) == 'object') {
	media_id.forEach(function(item, index) {
		list[index] = {};
		list[index].id = parseInt(item);
	});

	media_url.forEach(function(item, index) {
		list[index].url = item;
	});
console.warn(media_id, media_url);
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

