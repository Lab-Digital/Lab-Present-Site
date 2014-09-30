{extends file='page.tpl'}
{block name='links' append}
	<link href="/css/main.css" rel="stylesheet" />
	<link href="/css/404.css" rel="stylesheet" />
	<link href="/css/header.css" rel="stylesheet" />
	<link href="/css/footer.css" rel="stylesheet" />
{/block}
{block name='div.main'}
   {include file="header.tpl"}
	<div id="wrap_404">
		<img src="/images/404.png" id="main_404" />
		<div class="sorry_404">К сожалению, такой страницы не существует :(</div>
	</div>
   {include file="footer.tpl"}
{/block}