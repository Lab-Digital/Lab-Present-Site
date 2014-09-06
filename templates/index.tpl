{extends file='page.tpl'}
{block name='title'}{$meta.meta_title|default:'Lab Present - Главная'}{/block}
{block name='meta_description'}{$meta.meta_description|default:''}{/block}
{block name='meta_keywords'}{$meta.meta_keywords|default:''}{/block}
{block name='links' append}
	<link href="/css/header.css" rel="stylesheet" />
	<link href="/css/footer.css" rel="stylesheet" />
	<link href="/css/index.css" rel="stylesheet" />
	<link href="/css/forms.css" rel="stylesheet" />
  <link href="/css/upload_photos.css" rel="stylesheet" />
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
   {if $sliders|@count}
   <div class="slider">
      <ul class="bxslider">
        {foreach from=$sliders item=s name=f}
         <li>
            {if !empty($s.main_slider_url)}<a href="{$s.main_slider_url}">{/if}<div class="slide" style="background: url('/images/uploads/{$s.main_slider_avatar_id.name}_b.{$s.main_slider_avatar_id.ext}')"><div class="circle" style="background: #{$s.main_slider_color}; color: #{$s.main_slider_text_color}"><h1>{$s.main_slider_head}</h1><div class="text">{$s.main_slider_text}</div></div></div>{if !empty($s.main_slider_url)}</a>{/if}
         </li>
        {/foreach}
      </ul>
      <div id="sliderCtrl" style="margin-left: -{14 * $sliders|@count - 3}px;">
        {foreach from=$sliders item=s name=f}<li><a class="active" data-slide-index="{$smarty.foreach.f.index}">{$smarty.foreach.f.iteration}</a></li>{/foreach}
      </div>
   </div>
   {/if}
   <!-- slider end -->
   <!-- menu_first -->
   <section class="menu_first">
      <ul>
         {foreach from=$departments item=d}
            {if !empty($d.departments_avatar_id)}<li><a href="/departments/{$d.departments_url}"><img src="/images/uploads/{$d.departments_avatar_id.name}_s.{$d.departments_avatar_id.ext}" />{$d.departments_head}</a></li>{/if}
         {/foreach}
      </ul>
   </section>
   <!-- menu_first end -->
   <!-- news -->
   <section class="news">
      <div class="button_left"><button data-page="1" data-pages-amount="1" id="to_left" class="disabled"></button></div><div class="button_right"><button data-page="1" data-pages-amount="1" id="to_right" class="disabled"></button></div>
      <ul>
      </ul>
      <a href="/news" class="button" id="go_news_button">Новости</a>
   </section>
   <!-- news end -->
   <!-- menu_second -->
   <section class="menu_second">
      <ul>
      {foreach from=$projects item=p}
      <li><a href="/projects/{$p.projects_url}"><article><img src="/images/uploads/{$p.projects_avatar_id.name}_s.{$p.projects_avatar_id.ext}" /><h1>{$p.projects_head}</h1><div class="text">{$p.projects_description}</div></article></a></li>
      {/foreach}
      </ul>
   </section>
   <!-- menu_second end -->
   {include file="footer.tpl"}
{/block}
