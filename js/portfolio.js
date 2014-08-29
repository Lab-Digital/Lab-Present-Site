$(function(){
	$('#portfolio div.li img').click(function(){
		$this = $(this);

		$f = function() {
			var id = $this.parent().parent().attr('data');
			var photo_id = $this.attr('data');
			/*$.post(
	        	"/handler/",
	        	{
	        		id: photo_id
	        	},
	        	function(data) {
	        		result = data.result;
	        		var photo_open_id = result.photo_id;
	        		var photo_open_ext = result.photo_ext;
	        		var head = result.head;
	        		var text = result.text;
	        	}
	        );*/

			//все что ниже нужно делать в function(data) ajax запроса

			var photo_open_id = 12;
			var photo_open_ext = '.jpg';
			var head = 'Какой-то заголовок портфолио';
			var text = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut odio porta, cursus enim et, blandit augue. Praesent non lobortis lectus. <a href="#">Mauris</a> vitae diam sed lacus cursus maximus eu a magna. Quisque at lectus scelerisque, semper metus ornare, lobortis tellus. Sed eu maximus elit.</p><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer ultricies nibh metus, vel laoreet tellus rhoncus vel.</p>';
			var index = $this.parent().index();
			var arrow_left = index * 212 + 100 - 10; //index * 200 + index * 12 + 100 - 10;
			$('#tr' + id).after("<article id='open_image'><div class='arrow' style='left: " + arrow_left + "px;'></div><button id='close_image'>x</button><img src='/images/uploads/" + photo_open_id + "_b" + photo_open_ext + "' /><h1>" + head + "</h1><div class='text'>" + text + "</div></article>");
			$('#open_image').slideDown("500");
		}

		if ($('#open_image').length == 0) {
			$f();
		} else {
			$('#open_image').slideUp("500", function(){
				$(this).remove().empty();
				$f();
			});
		}
	});

	$('#portfolio').on("click", "#close_image", function(){
		$('#open_image').slideUp("500", function(){
			$(this).remove().empty();
		});
	});
});