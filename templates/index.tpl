{extends file='page.tpl'}
{block name='title'}{$meta.index_meta_title}{/block}
{block name='meta_description'}{$meta.index_meta_description}{/block}
{block name='meta_keywords'}{$meta.index_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/index.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
  <script src="/js/news.js"></script>
{/block}
{block name='div.main'}
   {include file="header.tpl"}
   <!-- slider -->
   <div class="slider">
   </div>
   <!-- slider end -->
   <!-- menu_first -->
   <section class="menu_first">
      <ul>
         {foreach from=$departments item=d}
            {if !empty($d.departments_avatar_id)}<li><a href="/departments/{$d.departments_url}"><img src="/images/uploads/{$d.departments_avatar_id}_s.jpg" />{$d.departments_head}</a></li>{/if}
         {/foreach}
      </ul>
   </section>
   <!-- menu_first end -->
   <!-- news -->
   <section class="news">
      <div class="button_left"><button data-page="1" data-pages-amount="1" id="to_left" class="disabled hidden"><</button></div><div class="button_right"><button data-page="1" data-pages-amount="1" id="to_right" class="disabled hidden">></button></div>
      <ul>
      </ul>
      <a href="#" id="go_news_button">Новости</a>
   </section>
   <!-- news end -->
   <!-- menu_second -->
   <section class="menu_second">
      <ul>
         <li><a href="#"><article><img src="menu_2_0.jpg" /><h1>Финн</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div></article></a></li><li><a href="#"><article><img src="menu_2_1.jpg" /><h1>Джейк</h1><div class="text">Lorem ipsum dolor Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div></article></a></li><li><a href="#"><article><img src="menu_2_2.jpg" /><h1>Снежный король</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div></article></a></li>
      </ul>
   </section>
   <!-- menu_second end -->
   {include file="footer.tpl"}
{/block}
