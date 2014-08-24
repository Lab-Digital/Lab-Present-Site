{extends file='admin.tpl'}
{block name='title' append} - Услуги{/block}
{block name='links' append}
   <link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
   <link rel="stylesheet" href="/css/styles_for_text.css" />
   <script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.js"></script>
   <script type="text/javascript" src="/js/select_plugin.js"></script>
   <script src="/upload_photo/js/plugin.js"></script>
   <script>
   {literal}
   $(function(){
      $('div.avatar_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'projects',
            'isAvatar'    : 'true',
            'item_id'     :  $data,
            'width'       : '100',
            'height'      : '100',
            'count'       : '1',
            'sizes'       : 's#100#100'
         });
      });
      $('a[rel^="gallery"]').fancybox();
      $('div.avatar_in a').fancybox();
   });
   {/literal}
   </script>
   <script src="/js/images.js"></script>
{/block}
{block name='main'}
   <h1>Слайдер</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   <div class="right_block">
      <label for="choose">Выберите слайд</label>
      <select id="choose_item">
         <option value="1">Слайд 1</option>   
      </select>
      <script type="text/javascript">
         //$('#choose_item option[value=""]').attr('selected', 'selected');
      </script>
      <h2>Редактирование слайда</h2>
      <div class="edit">
         <form action="" method="post" class="item_edit" id="">
            <input type="hidden" name="id" value="" />
            <div class="form_block">
               <label for="num_1">Порядковый номер</label>
               <input type="number" max="4" min="1" name="num" id="num_1" value="" />
            </div>
            <div class="form_block">
               <label for="url_1">URL</label>
               <input type="url" name="url" id="url_1" value="" />
            </div>
            <div class="buttons"><button name="mode" value="Update">Сохранить</button><button class="red" name="mode" value="Delete">Удалить</button></div>
         </form>
         <div class="in avatar_in">
            <h1 class="head_upload">Главное фото</h1>
            <button class="upload" type="submit" data="">Загрузить главное фото</button>
            <ul>
               
                  <li><a href="/images/uploads/{$d.projects_avatar_id}_s.jpg"><img src="/images/uploads/_s.jpg" /></a><button class="x" data="">x</button></li>
               
            </ul>
         </div>
      </div>
      {include file='admin.set_select.tpl'}
   </div>
{/block}