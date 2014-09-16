$(function(){

	function zoom(to_w, to_h, to_l, to_t, show) {

		var start_width = $('#overlay').width();
		var start_height = $('#overlay').height();
		var start_left = parseInt($('#overlay').css('left'));
		var start_top = parseInt($('#overlay').css('top'));
		
		$('#overlay').stop(true, true).animate(
			{
				width: to_w,
				height: to_h,
				left: to_l,
				top: to_t,
				opacity: show
			},
			{
				duration: 300,
				complete: function () {
					if (!show) {
						//$('#overlay').unbind('mouseleave');
						
					}
				}
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

	$('#map').mouseleave(function(){
		var end_width = 3833;
		var end_height = 654;
		var end_left = -1450;
		var end_top = -80;
		zoom(end_width, end_height, end_left, end_top, 1);
	});

/*	$('#s-location').mouseleave(function(){
		var start_width = $('#location-overlay img').width();
		var start_height = $('#location-overlay img').height();
		var end_width = 3833;
		var end_height = 654;
		var start_left = parseInt($('#location-overlay img').css('left'));
		var start_top = parseInt($('#location-overlay img').css('top'));
		
		$('#location-overlay img').stop(true, true).animate(
			{
				width: end_width,
				height: end_height,
				opacity: 1
			},
			{
				duration: 300,
				step: function( now, fx ) {
					if (fx.prop == 'width') {
						$(fx.elem).css('left', start_left - (now - start_width) / 2.1);
					}
					if (fx.prop == 'height') {
						$(fx.elem).css('top', start_top - (now - start_height) / 2.1);
					}
				},
				complete: function () {
				}
			}
		);
	});*/
});