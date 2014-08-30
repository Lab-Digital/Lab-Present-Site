<header>
	<a href="/"><img src="/images/logo.png" class="top_logo" /></a>
	<div class="right">
		<div class="top_info">
			<a href="mailto:info@adlab.ru" class="mailto">info@adlab.ru</a>
			<a href="tel:+74232434970" class="tel">8 (423) 243-49-70</a>
		</div>
		<button id="top_send">Отправить заявку</button>
		<nav>
			<ul>
				<li><a href="/resume">Резюме</a></li><li><a href="javascript:void(0);">Услуги</a><ul>{foreach from=$departments item=d}<li><a href="/departments/{$d.departments_url}">{$d.departments_head}</a></li>{/foreach}</ul></li><li><a href="/contacts">Контакты</a></li>
			</ul>
		</nav>
	</div>
</header>
<script src="/js/send_send.js"></script>
<script src="/js/send_to_mail.js"></script>
<script src="/js/jquery.form.js"></script>
<script type="text/javascript">
	var department_id = 0;
	$('header a[data="{$active_item|default:'main'}"]').addClass('active');
	{literal}
	$('#top_send').click(function(){
	  	$.fancybox([
			{
				href       : '#send_window',
				autoCenter : false
			}
		],
			{
				'autoDimensions'  : true,
				'width'           : 886,
				'height'          : 'auto',
				'transitionIn'    : 'none',
				'transitionOut'   : 'none'
			}
		);
		$("#category_choose li").removeClass('active');
	});
	{/literal}
</script>
<div style="display: none">
	<section id="send_window">
		<form id="proposal" action="/handler/proposal" method="post" enctype=multipart/form-data>
			<div class="main_send_block">
				<div class="left">
					<h1>Заявка</h1>
					<label for="name">Ваше имя:</label>
					<input id="name" name="name" class="good" class="form-control" />
					<label for="phone">Контактный телефон:</label>
					<input id="phone" type="phone" name="phone" class="form-control" />
					<label for="email">Ваш e-mail:</label>
					<input id="email" type="email" name="email" class="form-control" />
					<!-- <input id="params" type="hidden" name="params" class="form-control" />
					<input id="mode" type="hidden" name="mode" class="form-control" /> -->
				</div>
				<div class="right">
					<ul id="category_choose">
					{foreach from=$departments item=d}<li data="{$d.departments_id}">{$d.departments_head}</li>{/foreach}
					</ul>
					<input type="hidden" id="category" name="category" />
					<div class="textarea">
						<label for="text">Текст заявки</label>
						<textarea id="text" name="text" class="form-control"></textarea>
					</div>
				</div>
			</div>
			<div class="buttons">
				<button id="add_file" type="button">Прикрепить</button>
				<input  id="fake_input" type="file" max-size=15728640>
				<button id="send_send" type="sumbit">Отправить</button>
			</div>
			<div class="files_send_block">
				<table class="attachments">
				</table>
			</div>
		</form>

	</section>
</div>