{extends file='admin.tpl'}
{block name='title' append} - Отделы{/block}
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
            'uploadType'  : 'departments',
            'isAvatar'    : 'true',
            'item_id'     : $data,
            'width'       : '235',
            'height'      : '140',
            'count'       : '1',
            'sizes'       : 's#235#140'
         });
      });
      $('div.photos_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'departments',
            'item_id'     : $data,
            'width'       : '375',
            'height'      : '385',
            'count'       : '1',
            'sizes'       : 's#375#385'
         });
      });
      $('div.photos_in a').fancybox();
      $('div.avatar_in a').fancybox();
   });
   {/literal}
   </script>
   <script src="/js/images.js"></script>
{/block}
{block name='main'}
   <h1>Отделы</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   <div class="right_block">
      {if $departments|@count}
         <label for="choose_item">Выберите отдел</label>
         <select id="choose_item">
            {foreach from=$departments item=d}
               <option value="{$d.departments_id}">{$d.departments_head}</option>
            {/foreach}
         </select>
         <script type="text/javascript">
            $('#choose_item option[value="{$item_id}"]').attr('selected', 'selected');
         </script>
         <h2>Редактирование отдела</h2>
         {foreach from=$departments item=d name=f}
         <div class="edit">
            <form action="/admin/departments" method="post" class="item_edit" id="item{$d.departments_id}">
               <input type="hidden" name="id" value="{$d.departments_id}" />
               <div class="form_block">
                  <label for="head_{$smarty.foreach.f.index}">Заголовок</label>
                  <input name="head" id="head_{$smarty.foreach.f.index}" value="{if $isInsert}{$d.departments_head}{else}{$head|default:$d.departments_head}{/if}" />
               </div>
               <div class="form_block">
                  <label for="title_{$smarty.foreach.f.index}">Meta title</label>
                  <input name="title" id="title_{$smarty.foreach.f.index}" value="{if $isInsert}{$d.departments_meta_title}{else}{$mtitle|default:$d.departments_meta_title}{/if}" />
               </div>
               <div class="form_block">
                  <label for="body_{$smarty.foreach.f.index}">Текст</label>
                  <textarea name="body" id="body_{$smarty.foreach.f.index}" cols="90" rows="15">{if $isInsert}{$d.departments_body}{else}{$body|default:$d.departments_body}{/if}</textarea>
               </div>
               <div class="form_block">
                  <label for="meta_description_{$smarty.foreach.f.index}">Meta description</label>
                  <textarea name="description" id="meta_description_{$smarty.foreach.f.index}" cols="90" rows="10">{if $isInsert}{$d.departments_meta_description}{else}{$mdescription|default:$d.departments_meta_description}{/if}</textarea>
               </div>
               <div class="form_block">
                  <label for="keywords_{$smarty.foreach.f.index}">Meta keywords</label>
                  <textarea name="keywords" id="keywords_{$smarty.foreach.f.index}" cols="90" rows="10">{if $isInsert}{$d.departments_meta_keywords}{else}{$mkeywords|default:$d.departments_meta_keywords}{/if}</textarea>
               </div>
               <div class="buttons"><button name="mode" value="Update">Сохранить</button><button class="red" name="mode" value="Delete">Удалить</button></div>
            </form>
            <div class="in photos_in">
               <h1 class="head_upload">Фото</h1>
               <button class="upload" type="submit" data="{$d.departments_id}">Загрузить фото</button>
               <ul>
                  {if !empty($d.departments_photo_id)}
                     <li><a href="/images/uploads/{$d.departments_photo_id.name}_s.{$d.departments_photo_id.ext}"><img src="/images/uploads/{$d.departments_photo_id.name}_s.{$d.departments_photo_id.ext}" /></a><button class="x" data="{$d.departments_photo_id.name}" data-ext="{$d.departments_photo_id.ext}">x</button></li>
                  {/if}
               </ul>
            </div>
            <div class="in avatar_in">
               <h1 class="head_upload">Главное фото</h1>
               <button class="upload" type="submit" data="{$d.departments_id}">Загрузить главное фото</button>
               <ul>
                  {if !empty($d.departments_avatar_id)}
                     <li><a href="/images/uploads/{$d.departments_avatar_id.name}_s.{$d.departments_avatar_id.ext}"><img src="/images/uploads/{$d.departments_avatar_id.name}_s.{$d.departments_avatar_id.ext}" /></a><button class="x" data="{$d.departments_avatar_id.name}" data-ext="{$d.departments_avatar_id.ext}">x</button></li>
                  {/if}
               </ul>
            </div>
         </div>
         {/foreach}
         {include file='admin.set_select.tpl'}
      {/if}
      {if !$isInsert}
         {assign var='head' value=''}
         {assign var='desc' value=''}
         {assign var='body' value=''}
         {assign var='mtitle' value=''}
         {assign var='mkeywords' value=''}
         {assign var='mdescription' value=''}
      {/if}
      <h2>Добавление отдела</h2>
      <div class="add">
         <form action="/admin/departments" method="post">
            <div class="form_block">
               <label for="head_new">Заголовок</label>
               <input name="head" id="head_new" value="{$head}" />
            </div>
            <div class="form_block">
               <label for="title_new">Meta title</label>
               <input name="title" id="title_new" value="{$mtitle}" />
            </div>
            <div class="form_block">
               <label for="body_new">Текст</label>
               <textarea name="body" id="body_new" cols="90" rows="15">{$body}</textarea>
            </div>
            <div class="form_block">
               <label for="description_new">Meta description</label>
               <textarea name="description" id="description_new" cols="90" rows="10">{$mdescription}</textarea>
            </div>
            <div class="form_block">
               <label for="keywords_new">Meta keywords</label>
               <textarea name="keywords" id="keywords_new" cols="90" rows="10">{$mkeywords}</textarea>
            </div>
            <div class="buttons"><button id="add" name="mode" value="Insert">Добавить</button></div>
         </form>
      </div>
   </div>
{/block}