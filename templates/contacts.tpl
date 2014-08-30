{extends file='page.tpl'}
{block name='title'}{$meta.meta_title|default:'Lab Present - Резюме'}{/block}
{block name='meta_description'}{$meta.meta_description|default:''}{/block}
{block name='meta_keywords'}{$meta.meta_keywords|default:''}{/block}
{block name='links' append}
    <link href="/css/header.css" rel="stylesheet" />
    <link href="/css/footer.css" rel="stylesheet" />
    <link href="/css/contacts.css" rel="stylesheet" />
    <link href="/css/forms.css" rel="stylesheet" />  
{/block}
{block name='div.main'}
    {include file="header.tpl"}
    <div id="map">
        <div class="right">
            <form id="express_proposal" action="handler/proposal" method="post" enctype=multipart/form-data>
                <div class="top">
                    <h1>Экспресс-заявка</h1>
                    <label for="express_name">Ваше имя:</label>
                    <input id="express_name" name="express_name" class="good" class="form-control" />
                    <label for="express_phone">Контактный телефон:</label>
                    <input id="express_phone" type="phone" name="express_phone" class="form-control" />
                    <label for="express_email">Ваш e-mail:</label>
                    <input id="express_email" type="email" name="express_email" class="form-control" />
                    <input id="express_params" type="hidden" name="express_params" class="form-control" />
                    <input id="express_mode" type="hidden" name="express_mode" class="form-control" />
                </div>
                <div class="buttons">
                    <button id="express_send" type="sumbit">Отправить</button>
                </div>
            </form>
        </div>
    </div>
    {include file="footer.tpl"} 
{/block}
