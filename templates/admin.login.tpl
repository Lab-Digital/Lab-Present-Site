{extends file='html.tpl'}
{block name='title' append} - Вход{/block}
{block name='links' append}
  <link href="/css/admin_login.css" rel="stylesheet" />
  <link href="/css/main.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='page'}
<div id="floater">&nbsp;</div>
<div id="center_block">
  <form action="/admin/" method="POST" ENCTYPE="multipart/form-data">
    {if isset($invalid_pass)}<p class="invalid_pass">Неправильное имя пользователя или пароль</p>{/if}
    <div class="form_block">
      <label for="login">Логин</label>
      <input type="text" name="login" id="logim" value="{$admin_login|default:''}">
    </div>
    <div class="form_block">
      <label for="pass">Пароль</label>
      <input type="password" name="pass" id="pass">
    </div>
    <div class="buttons"><button type="submit" name="submit" value="submit">Войти</button></div>
  </form>
</div>
{/block}
