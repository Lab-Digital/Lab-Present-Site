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
      $('div.photos_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'resume',
            'item_id'     :  $data,
            'width'       : '355',
            'height'      : '695',
            'count'       : '1',
            'sizes'       : 's#100#196,b#355#695'
         });
      });
      $('div.photos_in a').fancybox();
   });
   {/literal}
   </script>
   <script src="/js/images.js"></script>
{/block}
{block name='main'}
   <h1>Резюме</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   <div class="right_block">
      {if $sliders|@count}
         <label for="choose">Выберите слайд</label>
         <select id="choose_item">
            {foreach from=$sliders item=s}
               <option value="{$s.resume_id}">Слайд {$s.resume_number}</option>
            {/foreach}
         </select>
         <script type="text/javascript">
            $('#choose_item option[value="{$item_id}"]').attr('selected', 'selected');
         </script>
         <h2>Редактирование слайда</h2>
         {foreach from=$sliders item=s name=f}
            <div class="edit">
               <form action="/admin/resume" method="post" class="item_edit" id="item{$s.resume_id}">
                  <input type="hidden" name="id" value="{$s.resume_id}" />
                  <div class="form_block">
                     <label for="head_{$smarty.foreach.f.index}">Заголовок слайда</label>
                     <input type="text" name="head" id="head_{$smarty.foreach.f.index}" value="{if $isInsert}{$s.resume_head}{else}{$head|default:$s.resume_head}{/if}" />
                  </div>
                  <div class="form_block">
                     <label for="num_{$smarty.foreach.f.index}">Порядковый номер</label>
                     <input type="number" min="1" name="number" id="num_{$smarty.foreach.f.index}" value="{if $isInsert}{$s.resume_number}{else}{$number|default:$s.resume_number}{/if}" />
                  </div>
                  <div class="form_block">
                    <label for="body_{$smarty.foreach.f.index}">Текст к слайду</label>
                    <textarea name="body" id="body_{$smarty.foreach.f.index}" rows="20" cols="90">{$body|default:$s.resume_body|default:''}</textarea>
                  </div>
                  <div class="buttons"><button name="mode" value="Update">Сохранить</button><button class="red" name="mode" value="Delete">Удалить</button></div>
               </form>
               <div class="in photos_in">
                  <h1 class="head_upload">Фото</h1>
                  <button class="upload" type="submit" data="{$s.resume_id}">Загрузить фото</button>
                  <ul>
                  {if !empty($s.resume_photo_id)}
                     <li><a href="/images/uploads/{$s.resume_photo_id.name}_s.{$s.resume_photo_id.ext}"><img src="/images/uploads/{$s.resume_photo_id.name}_s.{$s.resume_photo_id.ext}" /></a><button class="x" data="{$s.resume_photo_id.name}" data-ext="{$s.resume_photo_id.ext}">x</button></li>
                  {/if}
                  </ul>
               </div>
            </div>
         {/foreach}
         {include file='admin.set_select.tpl'}
      {/if}
      {if !$isInsert}
         {assign var='head' value=''}
         {assign var='number' value=''}
         {assign var='body' value=''}
      {/if}
      <div class="add">
         <h2>Добавление слайда</h2>
         <form action="/admin/resume" method="post">
            <input type="hidden" name="id" value="" />
            <div class="form_block">
               <label for="head_new">Заголовок слайда</label>
               <input type="text" name="head" id="head_new" value="{$head}" />
            </div>
            <div class="form_block">
               <label for="number_new">Порядковый номер</label>
               <input type="number" min="1" name="number" id="number_new" value="{$number|default:1}" />
            </div>
            <div class="form_block">
              <label for="body_new">Текст к слайду</label>
              <textarea name="body" id="body_new" rows="20" cols="90">{$body|default:''}</textarea>
            </div>
            <div class="buttons"><button id="add" name="mode" value="Insert">Добавить</button></div>
         </form>
      </div>
   </div>
{/block}