{extends file='admin.tpl'}
{block name='title' append} - Мета-данные{/block}
{block name='links' append}
   <script type="text/javascript" src="/js/select_plugin.js"></script>
{/block}
{block name='main'}
   <h1>Мета-данные</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   {if $meta|@count}
      <label for="choose_item">Выберите страницу</label>
      <select id="choose_item">
         {foreach from=$meta item=m}
            <option value="{$m.meta_id}">{$m.meta_head}</option>
         {/foreach}
      </select>
      {foreach from=$meta item=m name=f}
         <div class="edit">
            <form method="post" action="/admin/meta" class="item_edit" id="item{$m.meta_id}">
               <input type="hidden" name="id" value="{$m.meta_id}" />
               <div class="form_block">
                  <label for="title_{$smarty.foreach.f.index}">Meta title</label>
                  <input id="title_{$smarty.foreach.f.index}" name="title" value="{$meta_title|default:$m.meta_title}" />
               </div>
               <div class="form_block">
                  <label for="description_{$smarty.foreach.f.index}">Meta description</label>
                  <textarea id="description_{$smarty.foreach.f.index}" name="description" cols="90" rows="10">{$meta_description|default:$m.meta_description}</textarea>
               </div>
               <div class="form_block">
                  <label for="keywords_{$smarty.foreach.f.index}">Meta keywords</label>
                  <textarea id="keywords_{$smarty.foreach.f.index}" name="keywords" cols="90" rows="10">{$meta_keywords|default:$m.meta_keywords}</textarea>
               </div>
               <div class="buttons"><button id="save" name="mode" value="Update">Сохранить</button></div>
            </form>
         </div>
      {/foreach}
      {include file='admin.set_select.tpl'}
   {/if}
{/block}
