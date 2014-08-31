{extends file='admin.tpl'}
{block name='title' append} - Портфолио{/block}
{block name='links' append}
{/block}
{block name='main'}
  <h1>Портфолио</h1>
  {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
  <button onClick="javascript:location.assign('/admin/add/portfolio')" class="table_top_button">Добавить</button>
  <table>
  <tr class="head">
    <td>Название</td>
    <td>Категория</td>
    <td></td>
  </tr>
  {foreach from=$portfolio item=p}
  <tr>
    <td>{$p.portfolio_head}</td>
    <td>
    {foreach from=$p.portfolio_categories item=c}
      <span class="li">{$departments[$c]}</span>
    {foreachelse}
      -
    {/foreach}
    </td>
    <td class="buttons">
      <button title="Редактировать" class="edit" onClick="javascript:location.assign('/admin/edit/{$p.portfolio_id}/portfolio')"></button>
      <button title="Удалить" class="delete" onClick="javascript:location.assign('/admin/delete/{$p.portfolio_id}/portfolio')"></button>
    </td>
  </tr>
  {/foreach}
  </table>
  {if $pagesInfo.amount > 1}
  <div id="nav_num">
    {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<a class="{if $curPage == $t}active{/if}" href="/admin/portfolio/?page={$t}">{$t}</a>{/if}{/foreach}
  </div>
  {/if}
{/block}