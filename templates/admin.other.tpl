{extends file='admin.tpl'}
{block name='title' append} - Остальное{/block}
{block name='main'}
   <h1>Другое</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
    <form action="/admin/other" method="post" id="add_article">
      <div class="form_block">
        <label for="article_head">{$setting.settings_head}</label><input type="checkbox" name="is_visible" id="is_visible" {if $setting.settings_flag}checked="checked"{/if} value="1"/>
      </div>
      <div class="buttons"><button class="save" name="mode" value="Update">Сохранить</button></div>
    </form>
{/block}