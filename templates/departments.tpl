{extends file='page.tpl'}
{block name='title'}{$department.departments_meta_title}{/block}
{block name='meta_description'}{$department.departments_meta_description}{/block}
{block name='meta_keywords'}{$department.departments_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/departaments.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='div.main'}
   {include file="header.tpl"}
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
                  {if !empty($a.news_photo_id)}
                     <img src="/images/uploads/{$a.news_photo_id.name}_b.{$a.news_photo_id.ext}" alt="{$a.news_head}" class="photo" />
                  {/if}
                  <h1>{$a.news_head}</h1>
                  <div class="text">{$a.news_description}</div>
                  <a href="/news/{$a.news_url}" class="go">Далее</a>
                  <time>{$a.news_publication_date}</time>
               </article>
            </li>

         {/foreach}
         <a href="#" id="go_news">Новости</a>
         </ul>
      </div>
   </div>
   {include file="footer.tpl"} 
{/block}
