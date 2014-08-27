{extends file='admin.tpl'}
{block name='title' append} - Новости{/block}
{block name='links' append}
{/block}
{block name='main'}
  <h1>Новости</h1>
  {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
  <button onClick="javascript:location.assign('/admin/add/news')" class="table_top_button">Добавить</button>
  <table>
  <tr class="head">
    <td>Название</td>
    <td>Дата публикации</td>
    <td>Категория</td>
    <td></td>
  </tr>
  {foreach from=$news item=article}
  <tr>
    <td>{$article.news_head}</td>
    <td>{$article.news_publication_date}</td>
    <td>
    {foreach from=$article.news_categories item=c}
      <span class="li">{$departments[$c]}</span>
    {foreachelse}
      -
    {/foreach}
    </td>
    <td class="buttons">
      <button title="Редактировать" class="edit" onClick="javascript:location.assign('/admin/edit/{$article.news_id}/news')"></button>
      <button title="Удалить" class="delete" onClick="javascript:location.assign('/admin/delete/{$article.news_id}/news')"></button>
    </td>
  </tr>
  {/foreach}
  </table>
  {if $pagesInfo.amount > 0}
  <div id="nav_num">
    {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<a class="{if $curPage == $t}active{/if}" href="/admin/news/?page={$t}">{$t}</a>{/if}{/foreach}
  </div>
  {/if}
{/block}