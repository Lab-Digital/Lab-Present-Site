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
    <td>Имя: {$p.proposal_name}<br />Телефон: {$p.proposal_phone}<br />E-mail: {$p.proposal_email}<br /></td>
    <td>{$p.proposal_date}</td>
    <td>{$p.proposal_task}</td>
    <td>{$departments[$p.proposal_department_id]|default:'-'}</td>
    <td>{if !empty($p.proposal_zip_name)}<a href="/files/{$p.proposal_zip_name}.zip">ссылка на zip архив если есть. сделай пожалуйста иконочку зип архива</a>{/if}</td>
  </tr>
  {/foreach}
  </table>
  {if $pagesInfo.amount > 1}
  <div id="nav_num">
    {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<a class="{if $curPage == $t}active{/if}" href="/admin/proposals/?page={$t}">{$t}</a>{/if}{/foreach}
  </div>
  {/if}
{/block}