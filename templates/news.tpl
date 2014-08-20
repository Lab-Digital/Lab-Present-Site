{extends file='page.tpl'}
{block name='title'}{$meta.index_meta_title}{/block}
{block name='meta_description'}{$meta.index_meta_description}{/block}
{block name='meta_keywords'}{$meta.index_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/news.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='div.main'}
	{include file="header.tpl"}
	<div class="wrap_news">
		<div class="lineh1">
			<h1>Новости</h1>
		</div>
		<div class="wrap_news_inner">
			<article class="main">
				<h1>Заголовок новости</h1>
				<img src="#" class="main_photo" />
				<div class="text">
					<p>Мы делаем рекламу - девиз нашего отдела.</p>
					<p>Lorem ipsum dolor sit amet ipsum dolor sit amet ipsum dolor sit amet ipsum dolor sit amet. ipsum dolor sit amet ipsum dolor sit amet ipsum dolor sit amet.</p>
				</div>
				<time>25.01.2014</time>
			</article>
			<div class="watch_other">
				<h2>Читайте также:</h2>
				<ul>
					<li>
						<article>
							<img src="#" class="photo" />
							<h1>Открыт прием заявок открыт прием заявок</h1>
							<span>Добавлено:</span>
							<time>21.01.2014</time>
						</article>
					</li><li>
						<article>
							<img src="#" class="photo" />
							<h1>Открыт прием заявок открыт прием заявок</h1>
							<span>Добавлено:</span>
							<time>21.01.2014</time>
						</article>
					</li><li>
						<article>
							<img src="#" class="photo" />
							<h1>Открыт прием заявок открыт прием заявок</h1>
							<span>Добавлено:</span>
							<time>21.01.2014</time>
						</article>
					</li>
				</ul>
			</div>
		</div>
	</div>
	{include file="footer.tpl"} 
{/block}
