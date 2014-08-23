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
				<li><a href="#">Агенство</a></li><li><a href="#">Услуги</a><ul>{foreach from=$departments item=d}<li><a href="/departments/{$d.departments_url}">{$d.departments_head}</a></li>{/foreach}</ul></li><li><a href="#">Контакты</a></li>
			</ul>
		</nav>
	</div>
</header>
<script src="/js/send_send.js"></script>
<script type="text/javascript">
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
				'autoDimensions'  : false,
				'width'           : 886,
				'height'          : 'auto',
				'transitionIn'    : 'none',
				'transitionOut'   : 'none'
			}
		);
	});
	{/literal}
</script>
<div style="display: none">
	<section id="send_window">
		<form>
			<div class="main_send_block">
				<div class="left">
					<h1>Заявка</h1>
					<label for="name">Ваше имя:</label>
					<input id="name" name="name" class="good" />
					<label for="phone">Контактный телефон:</label>
					<input id="phone" type="phone" name="phone" class="wrong" />
					<label for="email">Ваше имя:</label>
					<input id="email" type="email" name="email" />
				</div>
				<div class="right">
					<ul id="category_choose">
						<li data="0">BTL</li><li data="1">Интернет</li><li data="2">Производство</li><li data="3">Размещение</li><li data="4">Видео</li><li data="5">Дизайн и креатив</li>
					</ul>
					<input type="hidden" id="category" name="category" />
					<div class="textarea">
						<label for="text">Текст заявки</label>
						<textarea id="text" name="text"></textarea>
					</div>
				</div>
			</div>
			<div class="buttons">
				<button id="add_file" type="button">Прикрепить</button>
				<button id="send_send" type="sumbit">Отправить</button>
			</div>
		</form>
		<div class="files_send_block">
			<table>
				<tr>
					<td class="num">1</td>
					<td class="name">Имя номер 1</td>
					<td class="delete" data="0">Удалить</td>
				</tr>
				<tr>
					<td class="num">2</td>
					<td class="name">Имя номер 2</td>
					<td class="delete" data="1">Удалить</td>
				</tr>
				<tr>
					<td class="num">3</td>
					<td class="name">Имя номер 3</td>
					<td class="delete" data="2">Удалить</td>
				</tr>
			</table>
		</div>
	</section>
</div>