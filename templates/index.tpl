{extends file='page.tpl'}
{block name='title'}{$meta.index_meta_title}{/block}
{block name='meta_description'}{$meta.index_meta_description}{/block}
{block name='meta_keywords'}{$meta.index_meta_keywords}{/block}
{block name='links' append}
	<link href="/css/header.css" rel="stylesheet" />
	<link href="/css/footer.css" rel="stylesheet" />
	<link href="/css/index.css" rel="stylesheet" />
	<link href="/css/forms.css" rel="stylesheet" />
   <link href="/css/jquery.bxslider.css" rel="stylesheet" />
   <script src="/js/jquery.bxslider.js"></script>
   <script src="/js/news.js"></script>
   <script>
      $(function(){
         $('.bxslider').bxSlider({
           'auto'          : true,
           'controls'      : true,
           'pagerCustom'   : '#sliderCtrl',
           'speed'         : 1000,
           'easing'        : 'ease-in-out',
           'adaptiveHeight': false,
           'infiniteLoop'  : true,
           'touchEnabled'  : false
         });
       });
   </script>
{/block}
{block name='div.main'}
   {include file="header.tpl"}
   <!-- slider -->
   <div class="slider">
      <ul class="bxslider">
         <li>
            <img src="/images/slider_1.jpg" />
         </li>
         <li>
            <img src="/images/slider_2.jpg" />
         </li>
         <li>
            <img src="/images/slider_3.jpg" />
         </li>
         <li>
            <img src="/images/slider_4.jpg" />
         </li>
      </ul>
      <div id="sliderCtrl">
         <li><a class="active" data-slide-index="0">1</a></li><li><a data-slide-index="1">2</a></li><li><a data-slide-index="2">3</a></li><li><a data-slide-index="3">4</a></li>
      </div>
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
      {foreach from=$projects item=p}
      <li><a href="#"><article><img src="/images/uploads/{$p.projects_avatar_id}_s.jpg" /><h1>{$p.projects_head}</h1><div class="text">{$p.projects_body}</div></article></a></li>
      {/foreach}
      </ul>
   </section>
   <!-- menu_second end -->
   {include file="footer.tpl"}
{/block}
