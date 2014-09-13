{extends file='html.tpl'}
{block name='links' append}
   <link href="/css/main.css" rel="stylesheet" />
   {literal}<style>body {background: #fff;}</style>{/literal}
{/block}
{block name='page'}
	<div style="width:900px; height:425px; background: url('/images/bgu.png'); margin: 100px auto">
	    <div style="width:900px; height:425px; background: url('/images/poly.png')"></div>
	</div>
	<div style="font-size: 180%; font-weight: bold; margin: 0 auto; text-align: center;">Страница не найдена! :(</div>
	<div style="font-size: 180%; font-weight: bold; margin: 100px auto 0; text-align: center;"><a href="/">На главную</a></div>
{/block}