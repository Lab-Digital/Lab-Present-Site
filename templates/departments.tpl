{extends file='page.tpl'}
{block name='title'}{$department.departments_meta_title}{/block}
{block name='meta_description'}{$department.departments_meta_description}{/block}
{block name='meta_keywords'}{$department.departments_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/departaments.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
  <link href="/css/portfolio.css" rel="stylesheet" />
  <script>
    {literal}
      $(function(){
        $('#portfolio_button').fancybox({'iframe': true, 'href':{/literal} '/portfolio/{$department.departments_id}'{literal}});
      });
    {/literal}
  </script>
{/block}
{block name='div.main'}
   {include file="header.tpl"}
   <table class="menu">
    <tr>{foreach from=$departments item=d}<td><a href="/departments/{$d.departments_url}" {if $d.departments_id==$department.departments_id}class="active"{/if}>{$d.departments_head}</a></td>{/foreach}</tr>
   </table>
   <div class="wrap_deps">
      <div class="main_block">
         <div class="left">
            <div class="photo">
            {if !empty($department.departments_photo_id)}
               <img src="/images/uploads/{$department.departments_photo_id.name}_s.{$department.departments_photo_id.ext}" alt="{$department.departments_head}" class="main_photo" />
            {/if}
            </div>
            <button id="portfolio_button">Портфолио</button>
            <button id="send_parts_button">Отправить заявку</button>
         </div>
         <article class="text">
          <h1>{$department.departments_head}</h1>
          {$department.departments_body}
         </article>
      </div>
      <div class="watch_other">
         <ul>
         {foreach from=$articles item=a}
            <li>
               <article>
                  {if !empty($a.news_other_photo_id)}
                     <a href="/news/{$a.news_url}"><img src="/images/uploads/{$a.news_other_photo_id.name}_b.{$a.news_other_photo_id.ext}" alt="{$a.news_head}" class="photo" /></a>
                  {/if}
                  <h1>{$a.news_head}</h1>
                  <div class="text">{$a.news_description}</div>
                  <a href="/news/{$a.news_url}" class="go">Далее</a>
                  <time>{$a.news_publication_date}</time>
               </article>
            </li>
         {/foreach}
         {if $pagesInfo.amount > 1}
            <div id="nav_num">
                {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<a class="{if $curPage == $t}active{/if}" href="/departments/{$department.departments_url}/?page={$t}">{$t}</a>{/if}{/foreach}
            </div>
         {/if}
         <a href="/news" id="go_news">Новости</a>
         </ul>
      </div>
   </div>
   {include file="footer.tpl"} 
{/block}
