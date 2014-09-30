{extends file='page.tpl'}
{block name='title'}{$meta.meta_title|default:'Lab Present - Резюме'}{/block}
{block name='meta_description'}{$meta.meta_description|default:''}{/block}
{block name='meta_keywords'}{$meta.meta_keywords|default:''}{/block}
{block name='links' append}
    <link href="/css/header.css" rel="stylesheet" />
    <link href="/css/footer.css" rel="stylesheet" />
    <link href="/css/contacts.css" rel="stylesheet" />
    <link href="/css/forms.css" rel="stylesheet" />
    <script type="text/javascript" src="/js/express_send.js"></script>
    <script src="/js/overlay.js"></script>
{/block}
{block name='div.main'}
    {include file="header.tpl"}
    <div id="map">
      <img id="map_overlay" src="/images/map.jpg" />
      <img id="overlay" src="/images/overlay.png" />
      <div class="right">
        <div id="hide_send_button" class="open"></div>
        <div id="send_form">
          <form id="express_proposal" action="/handler/proposal" method="post" enctype=multipart/form-data>
              <div class="top">
                  <h1>Экспресс-заявка</h1>
                  <div class="error"></div>
                  <label for="name">Ваше имя:</label>
                  <input id="name" name="name" class="form-control" />
                  <label for="phone">Контактный телефон:</label>
                  <input id="phone" type="phone" name="phone" class="form-control" />
                  <label for="email">Ваш e-mail:</label>
                  <input id="email" type="email" name="email" class="form-control" />
              </div>
              <div class="buttons">
                  <button id="express_send" type="sumbit">Отправить</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    {include file="footer.tpl"}
{/block}
