{extends file='html.tpl'}
{block name='title' append} - Смена пароля{/block}
{block name='links' append}
  <link href="/css/admin_login.css" rel="stylesheet" />
  <link href="/css/main.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='page'}
<div id="floater">&nbsp;</div>
<div id="center_block">
  <form action="/admin/change_data" method="POST">
    {if isset($error_txt)}<span class="error top_error">{$error_txt}</span>{/if}
    <div class="from_block">
      <label for="login">Логин</label>
      <input type="text" name="login" id="login" value="{$admin.admin_login|default:''}">
    </div>
    <div class="from_block">
      <label for="pass">Пароль</label>
      <input type="password" name="pass" id="pass">
    </div>
    <div class="from_block">
      <label for="new_pass">Новый пароль</label>
      <input type="password" name="new_pass" id="new_pass">
    </div>
    <div class="buttons"><button type="submit" name="mode" value="Update">Изменить</button><button id="cancel" type="button" onClick="javascript:location.assign('/admin')">Отмена</button></div>
  </form>
</div>
{/block}
