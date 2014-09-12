{extends file='admin.tpl'}
{block name='title' append} - Социальные сети{/block}
{block name='links' append}
   <script type="text/javascript" src="/js/select_plugin.js"></script>
   <script src="/upload_photo/js/plugin.js"></script>
   <script>
   {literal}
   $(function(){
      $('div.photos_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'socials',
            'item_id'     :  $data,
            'width'       : '30',
            'height'      : '30',
            'count'       : '1',
            'sizes'       : 's#30#30'
         });
      });
   });
   {/literal}
   </script>
   <script src="/js/images.js"></script>
{/block}
{block name='main'}
   <h1>Соц-сети</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   <div class="right_block">
      {if $socials|@count}
         <label for="choose">Выберите соц-сеть</label>
         <select id="choose_item">
            {foreach from=$socials item=s}
               <option value="{$s.socials_id}">{$s.socials_head}</option>
            {/foreach}
         </select>
         <script type="text/javascript">
            $('#choose_item option[value="{$item_id}"]').attr('selected', 'selected');
         </script>
         <h2>Редактирование</h2>
         {foreach from=$socials item=d name=f}
         <div class="edit">
            <form action="/admin/socials" method="post" class="item_edit" id="item{$d.socials_id}">
               <input type="hidden" name="id" value="{$d.socials_id}" />
               <div class="form_block">
                  <label for="head_{$smarty.foreach.f.index}">Название</label>
                  <input name="head" id="head_{$smarty.foreach.f.index}" value="{if $isInsert}{$d.socials_head}{else}{$head|default:$d.socials_head}{/if}" />
               </div>
               <div class="form_block">
                  <label for="url_{$smarty.foreach.f.index}">URL</label>
                  <input type="url" name="url" id="url_{$smarty.foreach.f.index}" value="{if $isInsert}{$d.socials_url}{else}{$url|default:$d.socials_url}{/if}" />
               </div>
               <div class="buttons"><button name="mode" value="Update">Сохранить</button><button class="red" name="mode" value="Delete">Удалить</button></div>
            </form>
            <div class="in photos_in">
               <h1 class="head_upload">Фото</h1>
               <button class="upload" type="submit" data="{$d.socials_id}">Загрузить фото</button>
               <ul>
                  {if !empty($d.socials_photo_id)}
                     <li><a href="/images/uploads/{$d.socials_photo_id.name}_s.{$d.socials_photo_id.ext}"><img src="/images/uploads/{$d.socials_photo_id.name}_s.{$d.socials_photo_id.ext}" style="width:30px;" /></a><button class="x" data="{$d.socials_photo_id.name}" data-ext="{$d.socials_photo_id.ext}">x</button></li>
                  {/if}
               </ul>
            </div>
         </div>
         {/foreach}
         {include file='admin.set_select.tpl'}
      {/if}
      {if !$isInsert}
         {assign var='head' value=''}
         {assign var='url' value=''}
      {/if}
      <h2>Добавление соц-сети</h2>
      <div class="add">
         <form action="/admin/socials" method="post">
            <div class="form_block">
               <label for="head_new">Заголовок</label>
               <input name="head" id="head_new" value="{$head}" />
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