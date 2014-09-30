$(function(){

	function zoom(to_w, to_h, to_l, to_t, show) {

		$('#overlay').stop(true, true).animate(
			{
				width: to_w,
				height: to_h,
				left: to_l,
				top: to_t,
				opacity: show
			},
			{
				duration: 300
			}
		);
	}

	$('#overlay').mouseenter(function(){
		var end_width = 3833 * 4;
		var end_height = 654 * 4;
		var end_left = -6975;
		var end_top = -1013;
		zoom(end_width, end_height, end_left, end_top, 0)
	});

	var end_l = -1450;

	function close_overlay() {
		var end_width = 3833;
		var end_height = 654;
		var end_left = end_l;
		var end_top = -80;
		zoom(end_width, end_height, end_left, end_top, 1);
	}

	$('#map').mouseleave(function(){
		close_overlay();
	});

	$('#map').on('click', '#hide_send_button.open', function(){
		$('#hide_send_button').removeClass('open').addClass('close');
		end_l = -1450 + ($('#hide_send_button').hasClass('close') ? 130 : 0);
		$('#map div.right').stop(true, true).animate(
			{ right: -330 },
			{
				duration: 300,
				complete: function () {
					$("#map_overlay").stop(true, true).animate(
						{ left: -370 },
						{
							duration: 200
						}
					);
					if ($("#overlay").css('opacity') == 1) {
						close_overlay();
					}
				}
			}
		);
	});
	$('#map').on('click', '#hide_send_button.close', function(){
		$('#hide_send_button').removeClass('close').addClass('open');
		end_l = -1450 + ($('#hide_send_button').hasClass('close') ? 130 : 0);
		$('#map div.right').stop(true, true).animate(
			{ right: 0 },
			{
				duration: 300,
				complete: function () {
					$("#map_overlay").stop(true, true).animate(
						{ left: -500 },
						{
							duration: 200
						}
					);
					if ($("#overlay").css('opacity') == 1) {
						close_overlay();
					}
				}
			}
		);
	});

});