$(function(){
   $('#send_send').click(function() {
      $form = $('#proposal');
      $.post(
         "/handler/proposal",
         {
            mode: 'Insert',
            params: {
                  name: $form.find('#name').val(),
                  email: $form.find('#email').val(),
                  phone: $form.find('#phone').val(),
                  task: $form.find('#text').val(),
                  department_id: $form.find('#category').val()
            }
         },
         function(data) {
            if (data.result) {
               $('#category_choose li').removeClass('active');
               $form.find('.form-control').each(function() {
                  $(this).val('');
               });
               $.fancybox(
                  '<span style="color: green; font-weight: bold; display: block; margin: 30px;">Заявка отправлена! Спасибо!</span>',
                  {
                     'autoDimensions'  : false,
                     'width'           : 360,
                     'height'          : 'auto',
                     'transitionIn'    : 'none',
                     'transitionOut'   : 'none'
                  }
               );
            } else {
              $.fancybox(
                  '<span style="color: red; font-weight: bold; display: block; margin: 30px;">' + data.message + '</span>',
                  {
                     'autoDimensions'  : false,
                     'width'           : 360,
                     'height'          : 'auto',
                     'transitionIn'    : 'none',
                     'transitionOut'   : 'none'
                  }
               );
            }
         },
         "json"
      );
      return false;
   });
});