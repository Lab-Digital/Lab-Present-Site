{extends file='admin.tpl'}
{block name='title' append} - Остальное{/block}
{block name='main'}
   <h1>Другое</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
    <form action="/admin/{$handle_url}" method="post" id="add_article">
      <div class="form_block">
        <label for="article_head">Заголовок</label><input type="checkbox" name="is_visible" id="is_visible" checked="checked" />
      </div>
      <div class="buttons"><button class="save" name="mode" value="Update">Сохранить</button></div>
    </form>
{/block}