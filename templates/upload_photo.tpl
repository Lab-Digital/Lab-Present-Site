{extends file='html.tpl'}
{block name='links' append}
  <link href="/upload_photo/css/main.css" rel="stylesheet" />
  <link href="/upload_photo/css/imgareaselect-default.css" rel="stylesheet" />
  <link href="/upload_photo/css/upload_photo.css" rel="stylesheet" />
  <link href="/upload_photo/css/resize_photo.css" rel="stylesheet" />
  <script src="/upload_photo/js/ajaxupload.3.5.js"></script>
  <script src="/upload_photo/js/imgareaselect.js"></script>
  <script src="/upload_photo/js/upload_photo.js"></script>
  <script>
    window.referer = '{$referer}';
  </script>
{/block}
{block name='page'}
  <div id="wrap">
    <section id="upload_photo">
      <button class="upload" data='{$photo_data}'>Выбрать фотографию</button>
      <small class="info">Минимальная ширина: <span class="_width"></span> пикс., минимальная высота: <span class="_height"></span> пикс., максимальный размер: <span class="_size"></span> Мб</small>
    </section>
    <section id="resize_photo">
      <img class="src_image" src="/scripts/uploads/72.jpg" />
      <small class="info">Выделите область фотографии чтобы обрезать её до нужных размеров</small>
      <button class="go_end">Сохранить</button>
    </section>
  </div>
{/block}