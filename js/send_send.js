$(function(){
	$('#category_choose li').click(function(){
		$('#category_choose li').removeClass('active');
		$(this).addClass('active');
		$('#category').val($(this).attr('data'));
	});
});