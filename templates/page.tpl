{extends file='html.tpl'}
{block name='links' append}
	<link href="/css/main.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.js"></script>
	<link href="/css/send.css" rel="stylesheet" />
	<script src="/js/send_send.js"></script>
	<script src="/js/send_to_mail.js"></script>
	<script src="/js/jquery.form.js"></script>
	{literal}
	<script type="text/javascript">
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
	</script>
	<script type="text/javascript">
		(function (d, w, c) {
		    (w[c] = w[c] || []).push(function() {
		        try {
		            w.yaCounter26100873 = new Ya.Metrika({id:26100873,
		                    clickmap:true,
		                    trackLinks:true,
		                    accurateTrackBounce:true});
		        } catch(e) { }
		    });

		    var n = d.getElementsByTagName("script")[0],
		        s = d.createElement("script"),
		        f = function () { n.parentNode.insertBefore(s, n); };
		    s.type = "text/javascript";
		    s.async = true;
		    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		    if (w.opera == "[object Opera]") {
		        d.addEventListener("DOMContentLoaded", f, false);
		    } else { f(); }
		})(document, window, "yandex_metrika_callbacks");
	</script>
	<noscript><div><img src="//mc.yandex.ru/watch/26100873" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-54648213-1', 'auto');
	  ga('send', 'pageview');

	</script>
	{/literal}
{/block}
{block name='page'}
	<div id="wrap">
		{block name='div.main'}{/block}
	</div>
{/block}