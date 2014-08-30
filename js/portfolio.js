portfolios = [];
$(function(){
   $('#portfolio div.li img').click(function(){
      $this = $(this);
      $('#open_image').remove().empty();
      var id = $this.parent().parent().attr('data');
      var photo_id = $this.attr('data');
      $.post(
         '/handler/portfolio',
         {
            id: photo_id
         },
         function(data) {
            if (data.result) {
               var head = data.info.portfolio_head;
               var text = data.info.portfolio_description;
               var head = 'Какой-то заголовок портфолио';
               var text = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut odio porta, cursus enim et, blandit augue. Praesent non lobortis lectus. <a href="#">Mauris</a> vitae diam sed lacus cursus maximus eu a magna. Quisque at lectus scelerisque, semper metus ornare, lobortis tellus. Sed eu maximus elit.</p><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer ultricies nibh metus, vel laoreet tellus rhoncus vel.</p>';
               var index = $this.parent().index();
               var length = $('#tr' + id).children().length;
               var arrow_left;
               switch (length) {
                  case 1:
                     arrow_left = 212 + 200 + 6 - 10; 
                     break;
                  case 2: 
                     arrow_left = (index + 1) * 212 + 100 - 10;
                     break;
                  case 3:
                     arrow_left = (index + 1) * 212 - 10 - 6;
                     break;
                  case 4:
                     arrow_left = index * 212 + 100 - 10; //index * 200 + index * 12 + 100 - 10;
                     break;
               }
               $('#tr' + id).after(
                  "<article id='open_image'><div class='arrow' style='left: " +
                  arrow_left + "px;'></div><button id='close_image'>x</button>" +
                  (data.info.portfolio_photo_id ? "<img src='/images/uploads/" + data.info.portfolio_photo_id.name + "_b." + data.info.portfolio_photo_id.ext + "' />" : '') +
                  "<h1>" + data.info.portfolio_head + "</h1><div class='text'>" + data.info.portfolio_description + "</div></article>"
               );
               $('#open_image').slideDown("500");
            }
         },
         "json"
      );
   });

   $('#portfolio').on("click", "#close_image", function(){
      $('#open_image').slideUp("500", function(){
         $(this).remove().empty();
      });
   });
});