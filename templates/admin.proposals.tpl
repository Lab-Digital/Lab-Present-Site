{extends file='admin.tpl'}
{block name='title' append} - Заявки{/block}
{block name='links' append}
{/block}
{block name='main'}
  <h1>Заявки</h1>
  <table>
  <tr class="head">
    <td>Информация о заказчике</td>
    <td>Дата заявки</td>
    <td>Задача</td>
    <td>Отдел</td>
    <td>Файлы</td>
  </tr>
  {foreach from=$proposals item=p}
  <tr>
    <td><span class="li">Имя: {$p.proposal_name}</span><span class="li">Телефон: {$p.proposal_phone}</span><span class="li">E-mail: {$p.proposal_email}</span></td>
    <td>{$p.proposal_date}</td>
    <td>{$p.proposal_task}</td>
    <td>{$departments[$p.proposal_department_id]|default:'-'}</td>
    <td>{if !empty($p.proposal_zip_name)}<a href="/files/{$p.proposal_zip_name}.zip">Скачать</a>{/if}</td>
  </tr>
  {/foreach}
  </table>
  {if $pagesInfo.amount > 1}
  <div id="nav_num">
    {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<a class="{if $curPage == $t}active{/if}" href="/admin/proposals/?page={$t}">{$t}</a>{/if}{/foreach}
  </div>
  {/if}
{/block}