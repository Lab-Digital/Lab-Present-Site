{extends file='admin.tpl'}
{block name='title' append} - Новости{/block}
{block name='links' append}
   <link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
   <link rel="stylesheet" href="/css/styles_for_text.css" />
   <script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.js"></script>
   <script src="/upload_photo/js/plugin.js"></script>
   <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/adapters/jquery.js"></script>
   <link rel="stylesheet" href="/css/jquery-ui.css">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
   <script src="/js/jquery-ui.js"></script>
   <script>
   {literal}
   $(function(){
      $('div.avatar_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'news',
            'isAvatar'    : 'true',
            'item_id'     : $data,
            'width'       : '150',
            'height'      : '150',
            'count'       : '1',
            'sizes'       : 's#150#150'
         });
      });
      $('div.bigphoto_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'news',
            'isBigphoto'  : 'true',
            'item_id'     : $data,
            'width'       : '900',
            'height'      : '300',
            'count'       : '1',
            'sizes'       : 's#102#34,b#900#300'
         });
      });
      $('div.watchother_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'   : 'news',
            'isWatchother' : 'true',
            'item_id'      : $data,
            'width'        : '560',
            'height'       : '270',
            'count'        : '1',
            'sizes'        : 's#280#135,b#560#270'
         });
      });
      $('div.text_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'   : 'news',
            'isTextPhoto'  : 'true',
            'item_id'      : $data,
            'width'        : '800',
            'height'       : '400',
            'count'        : '5',
            'sizes'        : 's#100#50,b#800#400'
         });
      });
      $('div.avatar_in a').fancybox();
      $('div.bigphoto_in a').fancybox();
      $('div.watchother_in a').fancybox();
      $('div.text_in a').fancybox();
      $('#article_date').datepicker({dateFormat: "dd.mm.yy"});
      $("textarea[name='body']").ckeditor();
   });
   {/literal}
   </script>
   <script src="/js/images.js"></script>
{/block}
{block name='main'}
   <h1>{if $isAdd|default:false}Добавление{else}Редактирование{/if} новости</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   <div class="right_block">
    <form action="/admin/{$handle_url}" method="post" id="add_article">
      <input type="hidden" class="article_id" name="id" value="{$article.news_id|default:''}" />
      <div class="form_block">
        <label for="article_head">Заголовок</label>
        <input name="head" id="article_head" value="{$head|default:$article.news_head|default:''}" />
      </div>
      <div class="form_block">
         <label for="title">Meta title</label>
         <input name="title" id="title" value="{$mtitle|default:$article.news_meta_title|default:''}" />
      </div>
      <div class="form_block">
        <label for="article_date">Дата публикации</label>
        <input name="date" id="article_date" value="{$date|default:$article.news_publication_date|default:''}" />
      </div>
      <div class="form_block div_checkbox">
        <label>Категория</label>
        <div class="checkbox_in">
          {if $cats|@count}
            {foreach from=$departments item=d}
            <div><input id="с_{$d.departments_id}" type="checkbox" name="categories[{$d.departments_id}]" {if !empty($cats[$d.departments_id])}checked{/if} value="1"/><label for="с_{$d.departments_id}">{$d.departments_head}</label></div>
            {/foreach}
          {else}
            {foreach from=$departments item=d}
            <div><input id="с_{$d.departments_id}" type="checkbox" name="categories[{$d.departments_id}]" {if !empty($article.news_categories[$d.departments_id])}checked{/if} value="1"/><label for="с_{$d.departments_id}">{$d.departments_head}</label></div>
            {/foreach}
          {/if}
        </div>
      </div>
      <div class="form_block">
        <label for="article_description">Описание новости</label>
        <textarea name="desc" id="article_description" rows="3" cols="90">{$desc|default:$article.news_description|default:''}</textarea>
      </div>
      <div class="form_block">
        <label for="article_body">Текст</label>
        <textarea name="body" id="article_body" rows="10" cols="90">{$body|default:$article.news_body|default:''}</textarea>
      </div>
      <div class="form_block">
         <label for="description">Meta description</label>
         <textarea name="description" id="description" cols="90" rows="10">{$mdescription|default:$article.news_meta_description|default:''}</textarea>
      </div>
      <div class="form_block">
         <label for="keywords">Meta keywords</label>
         <textarea name="keywords" id="keywords" cols="90" rows="10">{$mkeywords|default:$article.news_meta_keywords|default:''}</textarea>
      </div>
      <div class="buttons">{if $isAdd|default:false}<button class="save" name="mode" value="Insert">Добавить</button>{else}<button class="save" name="mode" value="Update">Сохранить</button><button class="delete red" name="mode" value="Delete">Удалить</button>{/if}</div>
    </form>
    {if !$isAdd|default:false}
      <div class="in avatar_in">
         <h1 class="head_upload">Фото для главной</h1>
         <button class="upload" type="submit" data="{$article.news_id}">Загрузить фото для главной</button>
         <ul>
            {if !empty($article.news_photo_id)}
               <li><a href="/images/uploads/{$article.news_photo_id.name}_s.{$article.news_photo_id.ext}"><img src="/images/uploads/{$article.news_photo_id.name}_s.{$article.news_photo_id.ext}" /></a><button class="x" data="{$article.news_photo_id.name}" data-ext="{$article.news_photo_id.ext}">x</button></li>
            {/if}
         </ul>
      </div>
      <div class="in bigphoto_in">
         <h1 class="head_upload">Большое фото</h1>
         <button class="upload" type="submit" data="{$article.news_id}">Загрузить большое фото</button>
         <ul>
            {if !empty($article.news_bigphoto_id)}
               <li><a href="/images/uploads/{$article.news_bigphoto_id.name}_b.{$article.news_bigphoto_id.ext}"><img src="/images/uploads/{$article.news_bigphoto_id.name}_s.{$article.news_bigphoto_id.ext}" /></a><button class="x" data="{$article.news_bigphoto_id.name}" data-ext="{$article.news_bigphoto_id.ext}">x</button></li>
            {/if}
         </ul>
      </div>
      <div class="in watchother_in">
         <h1 class="head_upload">Фото для "читайте также"</h1>
         <button class="upload" type="submit" data="{$article.news_id}">Загрузить фото для "читайте также"</button>
         <ul>
            {if !empty($article.news_other_photo_id)}
               <li><a href="/images/uploads/{$article.news_other_photo_id.name}_s.{$article.news_other_photo_id.ext}"><img src="/images/uploads/{$article.news_other_photo_id.name}_s.{$article.news_other_photo_id.ext}" /></a><button class="x" data="{$article.news_other_photo_id.name}" data-ext="{$article.news_other_photo_id.ext}">x</button></li>
            {/if}
         </ul>
      </div>
      <div class="in text_in">
         <h1 class="head_upload">Фото для текста</h1>
         <button class="upload" type="submit" data="{$article.news_id}">Загрузить фото для текста</button>
         <ul>
            {foreach from=$article.news_photos item=photo}<li><a href="/images/uploads/{$photo.name}_b.{$photo.ext}"><img src="/images/uploads/{$photo.name}_s.{$photo.ext}" /></a><button class="x" data="{$photo.name}" data-ext="{$photo.ext}">x</button></li>{/foreach}
         </ul>
      </div>
    {/if}
  </div>
{/block}