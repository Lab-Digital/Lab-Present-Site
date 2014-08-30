<footer>
   <nav>
    	<ul>
    		<li><a href="/resume">Резюме</a></li><li><a href="javascript:void(0);" id="send_from_footer">Отправить заявку</a></li><li><a href="#">Контакты</a></li>{foreach from=$departments item=d}<li><a href="/departments/{$d.departments_url}">{$d.departments_head}</a></li>{/foreach}
    	</ul>
   </nav>
</footer>
