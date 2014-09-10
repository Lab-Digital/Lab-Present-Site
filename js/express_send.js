$(function(){
  function clearForm() {
    $('#express_proposal').find('.form-control').each(function() {
       $(this).removeClass('wrong');
    });
    $('#express_proposal div.error').text('')
  }

  $('#express_send').click(function() {
    var options = {
       beforeSend: function() {
          clearForm()
       },
       uploadProgress: function(event, position, total, percentComplete) {
       },
       success: function() {
       },
       complete: function(response) {
          console.log('complete');
          console.log(JSON.stringify(response));
          console.log(response.responseText);
          var data = $.parseJSON(response.responseText);

          if (data.result) {
             $('#express_proposal').find('.form-control').each(function() {
                $(this).val('');
             });
             clearForm();
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
             if (data.error_field) {
                $('#express_proposal #' + data.error_field).addClass('wrong')
             }
             $('#express_proposal div.error').text(data.message);
            // $.fancybox(
            //     '<span style="color: red; font-weight: bold; display: block; margin: 30px;">' + data.message + '</span>',
            //     {
            //        'autoDimensions'  : false,
            //        'width'           : 360,
            //        'height'          : 'auto',
            //        'transitionIn'    : 'none',
            //        'transitionOut'   : 'none'
            //     }
            //  );
          }
       }
    };
    $("#express_proposal").ajaxForm(options);
  });
});