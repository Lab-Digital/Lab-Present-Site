{extends file='page.tpl'}
{block name='title'}{$meta.meta_title|default:'Lab Present - Новости'}{/block}
{block name='meta_description'}{$meta.meta_description|default:''}{/block}
{block name='meta_keywords'}{$meta.meta_keywords|default:''}{/block}
{block name='links' append}
    <link href="/css/header.css" rel="stylesheet" />
    <link href="/css/footer.css" rel="stylesheet" />
    <link href="/css/allnews.css" rel="stylesheet" />
    <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='div.main'}
    {include file="header.tpl"}
    <div class="wrap_news">
        <div class="lineh1">
            <h1>Новости</h1>
        </div>
        <ul class="news">
            {foreach from=$articles item=a}
            <li>
                <article>
                    {if !empty($a.news_other_photo_id)}
                        <a href="/news/{$a.news_url}"><img src="/images/uploads/{$a.news_other_photo_id.name}_s.{$a.news_other_photo_id.ext}" alt="{$a.news_head}" class="photo" /></a>
                    {/if}
                    <h1>{$a.news_head}</h1>
                    <div class="text">{$a.news_description}</div>
                    <a href="/news/{$a.news_url}" class="go">Далее</a>
                    <time>{$a.news_publication_date}</time>
                </article>
            </li>
            {/foreach}
        </ul>
        {*{if $pagesInfo.amount > 1}
            <div id="nav_num">
                {foreach from=$pagesInfo.num item=t}{if $t == '...'}<span class="between">. . .</span>{else}<a class="{if $curPage == $t}active{/if}" href="/departments/{$department.departments_url}/?page={$t}">{$t}</a>{/if}{/foreach}
            </div>
        {/if}*}
    </div>
   {include file="footer.tpl"} 
{/block}
