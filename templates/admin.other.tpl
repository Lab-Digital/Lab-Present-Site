{extends file='admin.tpl'}
{block name='title' append} - Остальное{/block}
{block name='links' append}
{/block}
{block name='main'}
   <h1>Остальное</h1>
   <h2>Мета-данные для главной страницы</h2>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   <form method="post" action="/admin/meta">
      <div class="form_block">
         <label for="title">Meta title</label>
         <input id="title" name="title" value="{$meta_title|default:$meta.index_meta_title}" />
      </div>
      <div class="form_block">
         <label for="description">Meta description</label>
         <textarea id="description" name="description" cols="90" rows="10">{$meta_description|default:$meta.index_meta_description}</textarea>
      </div>
      <div class="form_block">
         <label for="keywords">Meta keywords</label>
         <textarea id="keywords" name="keywords" cols="90" rows="10">{$meta_keywords|default:$meta.index_meta_keywords}</textarea>
      </div>
      <div class="buttons"><button id="save" name="mode" value="Update">Сохранить</button></div>
   </form>
{/block}