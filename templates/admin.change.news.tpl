{extends file='admin.tpl'}
{block name='title' append} - Новости{/block}
{block name='main'}
   <h1>{if $isAdd|default:false}Добавление{else}Редактирование{/if} новости</h1>
   {if isset($error_txt)}<p class="db_error">{$error_txt}</p>{/if}
   <div class="right_block">
    <form action="/admin/{$handle_url}" method="post" id="add_article">
      <input type="hidden" class="article_id" name="id" value="{$article.news_id|default:''}" />
      <div class="form_block">
        <label for="article_head_new">Заголовок</label>
        <input name="head" id="article_head_new" value="{$head|default:$article.news_head|default:''}" />
      </div>
      <div class="form_block">
         <label for="title_new">Meta title</label>
         <input name="title" id="title_new" value="{$mtitle|default:$article.news_meta_title|default:''}" />
      </div>
      <div class="form_block">
        <label for="article_description_new">Описание новости</label>
        <textarea name="desc" id="article_description_new" rows="3" cols="90">{$desc|default:$article.news_description|default:''}</textarea>
      </div>
      <div class="form_block">
        <label for="article_body_new">Текст</label>
        <textarea name="body" id="article_body_new" rows="10" cols="90">{$body|default:$article.news_body|default:''}</textarea>
      </div>
      <div class="form_block">
         <label for="description_new">Meta description</label>
         <textarea name="description" id="description_new" cols="90" rows="10">{$mdescription|default:$article.news_meta_description|default:''}</textarea>
      </div>
      <div class="form_block">
         <label for="keywords_new">Meta keywords</label>
         <textarea name="keywords" id="keywords_new" cols="90" rows="10">{$mkeywords|default:$article.news_meta_keywords|default:''}</textarea>
      </div>
      <div class="buttons">{if $isAdd|default:false}<button class="save" name="mode" value="Insert">Добавить</button>{else}<button class="save" name="mode" value="Update">Сохранить</button><button class="delete red" name="mode" value="Delete">Удалить</button>{/if}</div>
    </form>
  </div>
{/block}