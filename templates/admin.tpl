{extends file='html.tpl'}
{block name='title' append} - Админ-панель{/block}
{block name='links' append}
  <link href="/css/admin.css" rel="stylesheet" />
  <link href="/css/main.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
  <link href="/css/upload_photos.css" rel="stylesheet" />
{/block}
{block name='page'}
<div id="wrap">
  <header>
    <nav>
      <ul>
        <li><a href="/admin/news">Новости</a></li><li><a href="/admin/portfolio">Портфолио</a></li><li><a href="/admin/departments">Отделы</a></li><li><a href="/admin/projects">Проекты</a></li><li><a href="/admin/meta">Остальное</a></li><li><a href="/admin/change_data">Изменить данные</a></li><li><a href="/admin/logout">Выход</a></li>
      </ul>
    </nav>
  </header>
  {block name='main'}
  {/block}
</div>
{/block}
