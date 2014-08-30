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
            <form id="express_proposal" action="/handler/proposal" method="post" enctype=multipart/form-data>
                <div class="top">
                    <h1>Экспресс-заявка</h1>
                    <label for="name">Ваше имя:</label>
                    <input id="name" name="name" class="good" class="form-control" />
                    <label for="phone">Контактный телефон:</label>
                    <input id="phone" type="phone" name="phone" class="form-control" />
                    <label for="email">Ваш e-mail:</label>
                    <input id="email" type="email" name="email" class="form-control" />
                    <input id="is_express" name="is_express" type="hidden" value="1" />
                </div>
                <div class="buttons">
                    <button id="express_send" type="sumbit">Отправить</button>
                </div>
            </form>
            <script type="text/javascript">
               $('#express_send').click(function() {
                  var options = {
                     beforeSend: function() {
                     },
                     uploadProgress: function(event, position, total, percentComplete) {
                     },
                     success: function() {
                     },
                     complete: function(response) {
                        console.log('complete');
                        console.log(JSON.stringify(response));
                        console.log(response.responseText);
                        var data = $.parseJSON(response.responseText);

                        if (data.result) {
                           $('#express_proposal').find('.form-control').each(function() {
                              $(this).val('');
                           });
                           $.fancybox(
                              '<span style="color: green; font-weight: bold; display: block; margin: 30px;">Заявка отправлена! Спасибо!</span>',
                              {
                                 'autoDimensions'  : false,
                                 'width'           : 360,
                                 'height'          : 'auto',
                                 'transitionIn'    : 'none',
                                 'transitionOut'   : 'none'
                              }
                           );
                        } else {
                          $.fancybox(
                              '<span style="color: red; font-weight: bold; display: block; margin: 30px;">' + data.message + '</span>',
                              {
                                 'autoDimensions'  : false,
                                 'width'           : 360,
                                 'height'          : 'auto',
                                 'transitionIn'    : 'none',
                                 'transitionOut'   : 'none'
                              }
                           );
                        }
                     }
                  };
                  $("#express_proposal").ajaxForm(options);
               });
            </script>
        </div>
    </div>
    {include file="footer.tpl"}
{/block}