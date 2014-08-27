{extends file='page.tpl'}
{block name='title'}{$article.news_meta_title}{/block}
{block name='meta_description'}{$article.news_meta_description}{/block}
{block name='meta_keywords'}{$article.news_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/news.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='div.main'}
   {include file="header.tpl"}
   <div class="wrap_news">
      <div class="lineh1">
         <h1>Новости</h1>
      </div>
      <div class="wrap_news_inner">
         <article class="main">
            <h1>{$article.news_head}</h1>
            {if !empty($article.news_bigphoto_id)}
               <img src="/images/uploads/{$article.news_bigphoto_id.name}_b.{$article.news_bigphoto_id.ext}" alt="{$article.news_head}" class="main_photo" />
            {/if}
            <div class="text">{$article.news_body}</div>
            <time>{$article.news_publication_date}</time>
         </article>
         {if $other_articles|@count > 0}
         <div class="watch_other">
            <h2>Читайте также:</h2>
            <ul>
            {foreach from=$other_articles item=a}
               <li>
               <a href='/news/{$a.news_url}'>
                  <article>
                     {if !empty($a.news_other_photo_id)}<img src="/images/uploads/{$a.news_other_photo_id.name}_s.{$a.news_other_photo_id.ext}" class="photo" />{/if}
                     <h1>{$a.news_head}</h1>
                     <span>Добавлено:</span>
                     <time>{$a.news_publication_date}</time>
                  </article>
               </a>
               </li>
            {/foreach}
            </ul>
         </div>
         {/if}
      </div>
   </div>
   {include file="footer.tpl"} 
{/block}
