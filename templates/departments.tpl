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
   <div class="wrap_deps" style="background: url('/images/dephead{$department.departments_id}.png') 100% 0 no-repeat;">
      <div class="main_block">
         <div class="left">
            <div class="photo">
            {if !empty($department.departments_photo_id)}
               <img src="/images/uploads/{$department.departments_photo_id.name}_s.{$department.departments_photo_id.ext}" alt="{$department.departments_head}" class="main_photo" />
            {/if}
            </div>
            <button id="portfolio_button">Портфолио</button>
            <button id="send_parts_button">Отправить заявку</button>
            {literal}
            <script type="text/javascript">
               $('#send_parts_button').click(function() {
                  department_id = {/literal}{$department.departments_id}{literal};
                  $.fancybox([
                     {
                        href       : '#send_window',
                        autoCenter : false
                     }
                  ],
                     {
                        'autoDimensions'  : true,
                        'width'           : 886,
                        'height'          : 'auto',
                        'transitionIn'    : 'none',
                        'transitionOut'   : 'none'
                     }
                  );
                  $("#category_choose li").removeClass('active');
                  $("#category").val(department_id);
                  $("#category_choose li[data=" + department_id + "]").addClass('active');
               });
            </script>
            {/literal}
         </div>
         <article class="text">
          <h1>{$department.departments_head}</h1>
          <div class="text">{$department.departments_body}</div>
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
         <a href="/news" class="button" id="go_news">Все новости</a>
         </ul>
      </div>
   </div>
   {include file="footer.tpl"} 
{/block}
