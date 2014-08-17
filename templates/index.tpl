{extends file='page.tpl'}
{block name='title'}{$meta.index_meta_title}{/block}
{block name='meta_description'}{$meta.index_meta_description}{/block}
{block name='meta_keywords'}{$meta.index_meta_keywords}{/block}
{block name='links' append}
  <link href="/css/header.css" rel="stylesheet" />
  <link href="/css/footer.css" rel="stylesheet" />
  <link href="/css/index.css" rel="stylesheet" />
  <link href="/css/forms.css" rel="stylesheet" />
{/block}
{block name='div.main'}
	{include file="header.tpl"}
	<!-- slider -->
	<div class="slider">
	</div>
	<!-- slider end -->
	<!-- menu_first -->
	<section class="menu_first">
		<ul>
			<li><a href="#"><img src="menu_1_0.jpg" />Промоакции</a></li><li><a href="#"><img src="menu_1_1.jpg" />Реклама в интернете</a></li><li><a href="#"><img src="menu_1_2.jpg" />Производство рекламы</a></li><li><a href="#"><img src="menu_1_3.jpg" />Размещение рекламы</a></li><li><a href="#"><img src="menu_1_4.jpg" />Видео</a></li><li><a href="#"><img src="menu_1_5.jpg" />Дизайн и креатив</a></li>
		</ul>
	</section>
	<!-- menu_first end -->
	<!-- news -->
	<section class="news">
		<ul>
			<li><a href="#"><article><img src="news_0.jpg" /><h1>Новость 1</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet</div><time>21.01.2014</time></article></a></li><li><a href="#"><article><img src="news_1.jpg" /><h1>Новость 2</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div><time>21.01.2014</time></article></a></li><li><a href="#"><article><img src="news_2.jpg" /><h1>Новость 3</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div><time>21.01.2014</time></article></a></li><li><a href="#"><article><img src="news_3.jpg" /><h1>Новость 4</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div><time>21.01.2014</time></article></a></li>
		</ul>
		<a href="#" id="go_news_button">Новости</a>
	</section>
	<!-- news end -->
	<!-- menu_second -->
	<section class="menu_second">
		<ul>
			<li><a href="#"><article><img src="menu_2_0.jpg" /><h1>Финн</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div></article></a></li><li><a href="#"><article><img src="menu_2_1.jpg" /><h1>Джейк</h1><div class="text">Lorem ipsum dolor Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div></article></a></li><li><a href="#"><article><img src="menu_2_2.jpg" /><h1>Снежный король</h1><div class="text">Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet. Lorem ipsum dolor sit amet orem ipsum dolor sit amet orem ipsum dolor sit amet</div></article></a></li>
		</ul>
	</section>
	<!-- menu_second end -->
	{include file="footer.tpl"}
{/block}
