$(function(){
	$('div.in button.url').click(function(){
		$url = $(this).attr('data');
		prompt('URL фотографии для вставки в текст', $url);
	});
});