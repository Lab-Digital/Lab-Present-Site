{extends file='html.tpl'}
{block name='links' append}
	<link href="/css/main.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.js"></script>
	<link href="/css/send.css" rel="stylesheet" />
	<script src="/js/send_send.js"></script>
	<script src="/js/send_to_mail.js"></script>
	<script src="/js/jquery.form.js"></script>
	<script type="text/javascript">
		{literal}
		$(function(){
			$('#top_send, #send_parts_button, #send_from_footer').click(function(){
			  	$.fancybox([
					{
						href       : '#send_window',
						autoCenter : false
					}
				],
					{
						'autoDimensions'  : true,
						'transitionIn'    : 'none',
						'transitionOut'   : 'none'
					}
				);
			});
		});
		{/literal}
	</script>
{/block}
{block name='page'}
	<div id="wrap">
		{block name='div.main'}{/block}
	</div>
{/block}