$(function(){
	$('#map').on('click', '#hide_send_button.open', function(){
		$('#map div.right').stop(true, true).animate(
			{ right: -330 },
			{
				duration: 300,
				complete: function () {
					$('#hide_send_button').removeClass('open').addClass('close');
				}
			}
		);
	});
	$('#map').on('click', '#hide_send_button.close', function(){
		$('#map div.right').stop(true, true).animate(
			{ right: 0 },
			{
				duration: 300,
				complete: function () {
					$('#hide_send_button').removeClass('close').addClass('open');
				}
			}
		);
	});
});