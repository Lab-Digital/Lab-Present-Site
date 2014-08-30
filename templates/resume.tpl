{extends file='page.tpl'}
{block name='title'}{$meta.meta_title|default:'Lab Present - Резюме'}{/block}
{block name='meta_description'}{$meta.meta_description|default:''}{/block}
{block name='meta_keywords'}{$meta.meta_keywords|default:''}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/resume.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />  
  <link href="/css/jquery.bxslider.css" rel="stylesheet" />
  <script src="/js/jquery.bxslider.js"></script>
  <script>
    $(function(){
       $('.bxslider').bxSlider({
         'auto'          : true,
         'controls'      : true,
         'speed'         : 1000,
         'pause'         : 5000,
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
   <div class="wrap_resume">
      <div class="lineh1">
         <h1>Резюме</h1>
      </div>
   </div>
   <ul class="bxslider">
     {foreach from=$sliders item=s name=f}
      <li>
         <article class="slider_text">
           <h1>{$s.resume_head}</h1>
           <div class="text">{$s.resume_body}</div>
         </article>
         <img src="/images/uploads/{$s.resume_photo_id.name}_b.{$s.resume_photo_id.ext}" />
      </li>
     {/foreach}
   </ul>
   {include file="footer.tpl"} 
{/block}
