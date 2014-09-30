$(function(){
	$('#category_choose td').click(function(){
		$('#category_choose td').removeClass('active');
		$(this).addClass('active');
		$('#category').val($(this).attr('data'));
	});
});