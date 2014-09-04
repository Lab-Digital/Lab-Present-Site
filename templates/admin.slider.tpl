{extends file='admin.tpl'}
{block name='title' append} - Слайдер{/block}
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
            'uploadType'  : 'main_slider',
            'isAvatar'    : 'true',
            'item_id'     :  $data,
            'width'       : '1024',
            'height'      : '356',
            'count'       : '1',
            'sizes'       : 's#100#35,b#1024#356'
         });
      });
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
      {if $sliders|@count}
         <label for="choose">Выберите слайд</label>
         <select id="choose_item">
            {foreach from=$sliders item=s}
               <option value="{$s.main_slider_id}">Слайд {$s.main_slider_number}</option>
            {/foreach}
         </select>
         <script type="text/javascript">
            $('#choose_item option[value="{$item_id}"]').attr('selected', 'selected');
         </script>
         <h2>Редактирование слайда</h2>
         {foreach from=$sliders item=s name=f}
            <div class="edit">
               <form action="/admin/slider" method="post" class="item_edit" id="item{$s.main_slider_id}">
                  <input type="hidden" name="id" value="{$s.main_slider_id}" />
                  <div class="form_block">
                     <label for="num_{$smarty.foreach.f.index}">Порядковый номер</label>
                     <input type="number" min="1" name="number" id="num_{$smarty.foreach.f.index}" value="{if $isInsert}{$s.main_slider_number}{else}{$number|default:$s.main_slider_number}{/if}" />
                  </div>
                  <div class="form_block">
                     <label for="head_{$smarty.foreach.f.index}">Заголовок</label>
                     <input name="head" id="head_{$smarty.foreach.f.index}" value="{if $isInsert}{$s.main_slider_head}{else}{$head|default:$s.main_slider_head}{/if}" />
                  </div>
                  <div class="form_block">
                     <label for="text_{$smarty.foreach.f.index}">Текст</label>
                     <textarea name="text" id="text_{$smarty.foreach.f.index}" cols="90" rows="10">{if $isInsert}{$s.main_slider_text}{else}{$text|default:$s.main_slider_text}{/if}</textarea>
                  </div>
                  <div class="form_block">
                     <label for="color_{$smarty.foreach.f.index}">Цвет</label>
                     <input name="color" id="color_{$smarty.foreach.f.index}" value="{if $isInsert}{$s.main_slider_color}{else}{$color|default:$s.main_slider_color}{/if}" />
                  </div>
                  <div class="form_block">
                     <label for="url_{$smarty.foreach.f.index}">URL</label>
                     <input type="url" name="url" id="url_{$smarty.foreach.f.index}" value="{if $isInsert}{$s.main_slider_url}{else}{$url|default:$s.main_slider_url}{/if}" />
                  </div>
                  <div class="buttons"><button name="mode" value="Update">Сохранить</button><button class="red" name="mode" value="Delete">Удалить</button></div>
               </form>
               <div class="in avatar_in">
                  <h1 class="head_upload">Фото</h1>
                  <button class="upload" type="submit" data="{$s.main_slider_id}">Загрузить фото</button>
                  <ul>
                  {if !empty($s.main_slider_avatar_id)}
                     <li><a href="/images/uploads/{$s.main_slider_avatar_id.name}_s.{$s.main_slider_avatar_id.ext}"><img src="/images/uploads/{$s.main_slider_avatar_id.name}_s.{$s.main_slider_avatar_id.ext}" /></a><button class="x" data="{$s.main_slider_avatar_id.name}" data-ext="{$s.main_slider_avatar_id.ext}">x</button></li>
                  {/if}
                  </ul>
               </div>
            </div>
         {/foreach}
         {include file='admin.set_select.tpl'}
      {/if}
      {if !$isInsert}
         {assign var='url' value=''}
         {assign var='number' value=''}
         {assign var='head' value=''}
         {assign var='text' value=''}
         {assign var='color' value=''}
      {/if}
      <div class="add">
         <h2>Добавление слайда</h2>
         <form action="/admin/slider" method="post">
            <input type="hidden" name="id" value="" />
            <div class="form_block">
               <label for="number_new">Порядковый номер</label>
               <input type="number" min="1" name="number" id="number_new" value="{$number|default:1}" />
            </div>
            <div class="form_block">
               <label for="head_new">Заголовок</label>
               <input name="head" id="head_new" value="{$head}" />
            </div>
            <div class="form_block">
               <label for="text_new">Текст</label>
               <textarea name="text" id="text_new" cols="90" rows="10">{$text}</textarea>
            </div>
            <div class="form_block">
               <label for="color_new">Цвет</label>
               <input name="color" id="color_new" value="{$color}" />
            </div>
            <div class="form_block">
               <label for="url_new">URL</label>
               <input type="url" name="url" id="url_new" value="{$url}" />
            </div>
            <div class="buttons"><button id="add" name="mode" value="Insert">Добавить</button></div>
         </form>
      </div>
   </div>
{/block}