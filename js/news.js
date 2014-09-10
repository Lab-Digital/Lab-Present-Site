$(function(){
   function incPage(value) {
      $('section.news div.wrapper').attr('data-page',  parseInt($('section.news div.wrapper').attr('data-page')) + value);
   }

   function appendArticles($place, articles) {
      $html = "<ul>";
      for (var i = 0; i < articles.length; i++) {
         $html +=
            "<li><a href='/news/" + articles[i].news_url + "'><article>" +
            (articles[i].news_photo_id ? "<img src='/images/uploads/" + articles[i].news_photo_id.name + "_s." + articles[i].news_photo_id.ext +"' />" : "") +
            "<div class='head'><h1>" + articles[i].news_head + "</h1></div>" +
            "<time>" + articles[i].news_publication_date + "</time>" +
            "</article></a></li>";
      };
      $html += "</ul>";
      $place.append($html);
   }

   function getNews(p) {
      var result = false;
      $.post(
         "/handler/news",
         {
            page: p - 1
         },
         function(data) {
            result = data.result;
            $place = $('section.news div.wrapper');
            if (result) {
               $place.attr('data-pages-amount', data.pages_amount);
               $place.attr('data-last', Math.max($place.attr('data-last'), $place.attr('data-page')));

               appendArticles($place, data.news);
               
               $place.stop(true, true).animate(
                  { marginLeft: "-=1024" },
                  { duration: 500 }
               );

               checkArrows();
            }
         },
         "json"
      );
      return result;
   }

   function checkArrows() {
      $place = $('section.news div.wrapper');
      var cur_page = $place.attr('data-page');
      var pages_amount = $place.attr('data-pages-amount');
      
      enableButton('left');
      enableButton('right');

      if (pages_amount == 0 || ((cur_page == pages_amount) && cur_page == 1)) {
         disableButton('left');
         disableButton('right');
         alert('f');
      }

      if (cur_page == pages_amount) {
         disableButton('right');
      }

      if (cur_page == 1) {
         disableButton('left');
      }

   }

   $("body").on('click', '#to_left.enabled', function() {
      incPage(-1);
      $('section.news div.wrapper').stop(true, true).animate(
         { marginLeft: "+=1024" },
         { duration: 500 }
      );
      checkArrows();
      //enableButton('right');
   });

   $("body").on('click', '#to_right.enabled', function() {
      incPage(1);
      if ($('section.news div.wrapper').attr('data-last') < $('section.news div.wrapper').attr('data-page')) {
         getNews($('section.news div.wrapper').attr('data-page'));
      } else {
         $('section.news div.wrapper').stop(true, true).animate(
            { marginLeft: "-=1024" },
            { duration: 500 }
         );
         checkArrows();
      }
      //enableButton('');
   });

   getNews(1);

   function disableButton(button) {
      $('#to_' + button).removeClass('enabled').addClass('disabled');
   }

   function enableButton(button) {
      $('#to_' + button).removeClass('disabled').addClass('enabled');
   }

});