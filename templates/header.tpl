<header>
	{if !$is_main|default:false}<a href="/">{/if}<img src="/images/logo.png" class="top_logo" />{if !$is_main|default:false}</a>{/if}
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
<div style="display: none">
	<section id="send_window">
		<form id="proposal" action="/handler/proposal" method="post" enctype=multipart/form-data>
			<div class="main_send_block">
				<div class="left">
					<h1>Заявка</h1>
					<div class="error"></div>
					<label for="name">Ваше имя:</label>
					<input id="name" name="name" class="form-control" />
					<label for="phone">Контактный телефон:</label>
					<input id="phone" type="phone" name="phone" class="form-control" />
					<label for="email">Ваш e-mail:</label>
					<input id="email" type="email" name="email" class="form-control" />
					<!-- <input id="is_express" type="hidden" name="is_express" value="0" /> -->
				</div>
				<div class="right">
					<ul id="category_choose">
					{foreach from=$departments item=d name=f}<li data="{$d.departments_id}">{$d.departments_head}</li>{if ($smarty.foreach.f.index + 1) % 3 == 0}<br />{/if}{/foreach}
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