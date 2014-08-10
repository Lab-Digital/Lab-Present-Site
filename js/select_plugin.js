$(function(){
   $('#choose_item').change(function(){
      $('.item_edit').parent().hide();
      $('div.upload_photos').hide();
      $('#item' + $('#choose_item option:selected').val()).parent().show();
      $('.div_upload' + $('#choose_item option:selected').val()).css('display', 'block');
   });
   $('#choose_item').change();
});