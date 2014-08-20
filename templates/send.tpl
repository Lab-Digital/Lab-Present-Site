{extends file='html.tpl'}
{block name='links' append}
  <link href="/css/send.css" rel="stylesheet" />
{/block}
{block name='page'}
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
					<ul>
						<li class="active">BTL</li><li>Интернет</li><li>Производство</li><li>Размещение</li><li>Видео</li><li>Дизайн и креатив</li>
					</ul>
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
{/block}
