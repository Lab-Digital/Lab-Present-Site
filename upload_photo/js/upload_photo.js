$(function() {
  $btnUpload = $('button.upload');
  $data = JSON.parse($btnUpload.attr('data'));

  $('span._width').text($data.width);
  $('span._height').text($data.height);
  $('span._size').text(($data.maxSize / 1024 / 1024).toFixed(2));

  $resize = {};

  new AjaxUpload($btnUpload, {
    action: '/uploadimage',
    name: 'uploadimage',
    data: $data,
    onSubmit: function(file, ext) {
      if (!(ext && /^(jpg|jpeg)$/.test(ext))) {
        // extension is not allowed
        alert('Это разрешение не поддерживается. Только JPG.');
        return false;
      }
    },
    onComplete: function(file, response) {
      $response = JSON.parse(response);
      $fileTmpName = $response.file_tmp;
      if ($response.result) {

        $data.fileName = $response.file;

        $('#upload_photo').hide();
        $('#resize_photo img.src_image').attr('src', '/images/uploads/' + $response.file + '.jpg');

        $imgWidth = $data.width;
        $imgHeight = $data.height;
        $imgOwnerWidth = $response.width;
        $imgOwnerHeight = $response.height;

        $x1 = Math.floor(($imgOwnerWidth - $imgWidth) / 2);
        $y1 = Math.floor(($imgOwnerHeight - $imgHeight) / 2);
        $x2 = parseInt($x1) + parseInt($imgWidth);
        $y2 = parseInt($y1) + parseInt($imgHeight);

        $resize.x1 = $x1;
        $resize.y1 = $y1;
        $resize.x2 = $x2;
        $resize.y2 = $y2;

        $('#resize_photo img.src_image').imgAreaSelect({
          handles: true,
          persistent: true,
          minWidth: $imgWidth,
          minHeight: $imgHeight,
          aspectRatio: $imgWidth + ':' + $imgHeight,

          x1: $x1,
          y1: $y1,
          x2: $x2,
          y2: $y2,

          onSelectChange: function (img, selection) {

            $resize.x1 = selection.x1;
            $resize.y1 = selection.y1;
            $resize.x2 = selection.x2;
            $resize.y2 = selection.y2;

          }
        });
        $('#resize_photo').show();
      } else {
        alert('Файл ' + $fileTmpName + ' не может быть загружен. ' + $response.message);
      }
    }
  });

   $('#resize_photo button.go_end').click(function() {
      $.extend($resize, $data);
      $.post(
         "/resizeimage",
         $resize,
         function(data) {
            if (data.result) {
               document.location.replace(window.referer + '/?item_id=' + $data.item_id);
            } else {
               alert(data.message);
            }
         },
         "json"
      );
   });
});