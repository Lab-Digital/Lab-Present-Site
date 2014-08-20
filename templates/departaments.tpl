{extends file='page.tpl'}
{block name='title'}{$meta.index_meta_title}{/block}
{block name='meta_description'}{$meta.index_meta_description}{/block}
{block name='meta_keywords'}{$meta.index_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/departaments.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='div.main'}
	{include file="header.tpl"}
	<div class="wrap_deps">
		<div class="main_block">
			<div class="left">
				<div class="photo">
					<img src="#" />
				</div>
				<button id="portfolio_button">Портфолио</button>
				<button id="send_parts_button">Отправить заявку</button>
			</div>
			<article class="text">
				<p>Мы делаем рекламу - девиз нашего отдела.</p>
				<p>Lorem ipsum dolor sit amet ipsum dolor sit amet ipsum dolor sit amet ipsum dolor sit amet. ipsum dolor sit amet ipsum dolor sit amet ipsum dolor sit amet.</p>
			</article>
		</div>
		<div class="watch_other">
			<ul>
				<li>
					<article>
						<img src="#" class="photo" />
						<h1>Открыт прием заявок</h1>
						<div class="text">
							Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet
						</div>
						<a href="#" class="go">Далее</a>
						<time>21.01.2014</time>
					</article>
				</li>
				<li>
					<article>
						<img src="#" class="photo" />
						<h1>Открыт прием заявок</h1>
						<div class="text">
							Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet
						</div>
						<a href="#" class="go">Далее</a>
						<time>21.01.2014</time>
					</article>
				</li>
				<li>
					<article>
						<img src="#" class="photo" />
						<h1>Открыт прием заявок</h1>
						<div class="text">
							Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet
						</div>
						<a href="#" class="go">Далее</a>
						<time>21.01.2014</time>
					</article>
				</li>
				<a href="#" id="go_news">Новости</a>
			</ul>
		</div>
	</div>
	{include file="footer.tpl"} 
{/block}
