{extends file='admin.tpl'}
{block name='title' append} - Новости{/block}
{block name='links' append}
   <link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
   <script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.js"></script>
   <script src="/upload_photo/js/plugin.js"></script>
   <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/adapters/jquery.js"></script>
   <script>
   {literal}
   $(function(){
      $('div.avatar_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'portfolio',
            'isAvatar'    : 'true',
            'item_id'     :  $data,
            'width'       : '200',
            'height'      : '200',
            'count'       : '1',
            'sizes'       : 's#200#200'
         });
      });
      $('div.photos_in button.upload').each(function(){
         $data = $(this).attr('data');
         $(this).getUpload({
            'uploadType'  : 'portfolio',
            'item_id'     :  $data,
            'width'       : '806',
            'height'      : '300',
            'count'       : '1',
            'sizes'       : 's#100#37,b#806#300'
         });
      });
      $('div.avatar_in a').fancybox();
      $('div.photos_in a').fancybox();

      CKEDITOR.replace('article_description', {
        toolbar: [
          { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
          { name: 'links', items: [ 'Link', 'Unlink' ] },
          { name: 'insert', items: [ 'SpecialChar' ] },
          { name: 'document', items: [ 'Source' ] },
          '/',
          { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
          { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ] }
        ]
      });
   });
   {/literal}
   </script>
   <script src="/js/images.js"></script>
{/block}
{block name='main'}
   <h1>{if $isAdd|default:false}Добавление{else}Редактирование{/if} портфолио</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
    <form action="/admin/{$handle_url}" method="post" id="add_article">
      <input type="hidden" class="article_id" name="id" value="{$portfolio.portfolio_id|default:''}" />
      <div class="form_block">
        <label for="article_head">Заголовок</label>
        <input name="head" id="article_head" value="{$head|default:$portfolio.portfolio_head|default:''}" />
      </div>
      <div class="form_block div_checkbox">
        <label>Отдел</label>
        <div class="checkbox_in">
          {if $cats|@count}
            {foreach from=$departments item=d}
            <div><input id="с_{$d.departments_id}" type="checkbox" name="categories[{$d.departments_id}]" {if !empty($cats[$d.departments_id])}checked{/if} value="1"/><label for="с_{$d.departments_id}">{$d.departments_head}</label></div>
            {/foreach}
          {else}
            {foreach from=$departments item=d}
            <div><input id="с_{$d.departments_id}" type="checkbox" name="categories[{$d.departments_id}]" {if !empty($portfolio.portfolio_categories[$d.departments_id])}checked{/if} value="1"/><label for="с_{$d.departments_id}">{$d.departments_head}</label></div>
            {/foreach}
          {/if}
        </div>
      </div>
      <div class="form_block">
        <label for="article_description">Описание портфолио</label>
        <textarea name="desc" id="article_description">{$desc|default:$portfolio.portfolio_description|default:''}</textarea>
      </div>
      <div class="buttons">{if $isAdd|default:false}<button class="save" name="mode" value="Insert">Добавить</button>{else}<button class="save" name="mode" value="Update">Сохранить</button><button class="delete red" name="mode" value="Delete">Удалить</button>{/if}</div>
    </form>
    {if !$isAdd|default:false}
    <div class="in avatar_in">
       <h1 class="head_upload">Главное фото</h1>
       <button class="upload" type="submit" data="{$portfolio.portfolio_id}">Загрузить главное фото</button>
       <ul>
          {if !empty($portfolio.portfolio_avatar_id)}
             <li><a href="/images/uploads/{$portfolio.portfolio_avatar_id.name}_b.{$portfolio.portfolio_avatar_id.ext}" rel="gallery_{$portfolio.portfolio_id}"><img src="/images/uploads/{$portfolio.portfolio_avatar_id.name}_s.{$portfolio.portfolio_avatar_id.ext}" /></a><button class="x" data="{$portfolio.portfolio_avatar_id.name}" data-ext="{$portfolio.portfolio_avatar_id.ext}">x</button></li>
          {/if}
       </ul>
    </div>
    <div class="in photos_in">
       <h1 class="head_upload">Фото</h1>
       <button class="upload" type="submit" data="{$portfolio.portfolio_id}">Загрузить фото</button>
       <ul>
          {if !empty($portfolio.portfolio_photo_id)}
             <li><a href="/images/uploads/{$portfolio.portfolio_photo_id.name}_b.{$portfolio.portfolio_photo_id.ext}" rel="gallery_{$portfolio.portfolio_id}"><img src="/images/uploads/{$portfolio.portfolio_photo_id.name}_s.{$portfolio.portfolio_photo_id.ext}" /></a><button class="x" data="{$portfolio.portfolio_photo_id.name}" data-ext="{$portfolio.portfolio_photo_id.ext}">x</button></li>
          {/if}
       </ul>
    </div>
    {/if}
{/block}