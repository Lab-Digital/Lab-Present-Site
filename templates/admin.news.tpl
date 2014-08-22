{extends file='admin.tpl'}
{block name='title' append} - Новости{/block}
{block name='links' append}
{/block}
{block name='main'}
  <h1>Новости</h1>
  {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
  <div class="buttons"><button onClick="javascript:location.assign('/admin/add/news')">Добавить</button></div>
  <div class="right_block">
    <table>
    <tr class="head">
      <td>Название</td>
      <td>Дата публикации</td>
      <td>Категория</td>
      <td>Meta title</td>
      <td>Meta description</td>
      <td>Meta keywords</td>
      <td></td>
    </tr>
    {foreach from=$news item=article}
    <tr>
      <td>{$article.news_head}</td>
      <td>{$article.news_publication_date}</td>
      <td>
      {foreach from=$article.news_categories item=c}
        {$departments[$c]}<br />
      {foreachelse}
        -
      {/foreach}
      </td>
      <td>{$article.news_meta_title}</td>
      <td>{$article.news_meta_description}</td>
      <td>{$article.news_meta_keywords}</td>
      <td class="buttons">
        <button title="Редактировать" class="edit" onClick="javascript:location.assign('/admin/edit/{$article.news_id}/news')"></button>
        <button title="Удалить" class="delete" onClick="javascript:location.assign('/admin/delete/{$article.news_id}/news')"></button>
      </td>
    </tr>
    {/foreach}
    </table>
    {if $pagesInfo.amount > 0}
    <div id="nav_num">
      {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<button class="{if $curPage == $t}active{/if}" onClick="javascript:location.assign('/admin/news/?page={$t}')">{$t}</button>{/if}{/foreach}
    </div>
    {/if}
  </div>
{/block}