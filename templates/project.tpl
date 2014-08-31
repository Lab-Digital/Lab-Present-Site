{extends file='page.tpl'}
{block name='title'}{$project.projects_meta_title}{/block}
{block name='meta_description'}{$project.projects_meta_description}{/block}
{block name='meta_keywords'}{$project.projects_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/project.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='div.main'}
   {include file="header.tpl"}
   <div class="wrap_project">
      <div class="lineh1">
         <h1>Проекты</h1>
      </div>
      <div class="wrap_project_inner">
         <article class="main">
            <h1>{$project.projects_head}</h1>
            {if !empty($project.projects_photo_id)}
               <img src="/images/uploads/{$project.projects_photo_id.name}_b.{$project.projects_photo_id.ext}" alt="{$project.projects_head}" class="main_photo" />
            {/if}
            <div class="text">{$project.projects_body}</div>
         </article>
      </div>
   </div>
   {include file="footer.tpl"}
{/block}
