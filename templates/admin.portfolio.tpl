{extends file='admin.tpl'}
{block name='title' append} - Новости{/block}
{block name='links' append}
{/block}
{block name='main'}
  <h1>Портфолио</h1>
  {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
  <div class="buttons"><button onClick="javascript:location.assign('/admin/add/portfolio')">Добавить</button></div>
  <div class="right_block">
    <table>
    <tr class="head">
      <td>Название</td>
      <td>Описание</td>
      <td></td>
    </tr>
    {foreach from=$portfolio item=p}
    <tr>
      <td>{$p.portfolio_head}</td>
      <td>{$p.portfolio_description}</td>
      <td class="buttons">
        <button title="Редактировать" class="edit" onClick="javascript:location.assign('/admin/edit/{$p.portfolio_id}/portfolio')"></button>
        <button title="Удалить" class="delete" onClick="javascript:location.assign('/admin/delete/{$p.portfolio_id}/portfolio')"></button>
      </td>
    </tr>
    {/foreach}
    </table>
    {if $pagesInfo.amount > 0}
    <div id="nav_num">
      {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<button class="{if $curPage == $t}active{/if}" onClick="javascript:location.assign('/admin/portfolio/?page={$t}')">{$t}</button>{/if}{/foreach}
    </div>
    {/if}
  </div>
{/block}