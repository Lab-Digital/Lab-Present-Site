<footer>
   <nav>
      <ul>
      {foreach from=$departments item=d}<li><a href="/departments/{$d.departments_url}">{$d.departments_head}</a></li>{/foreach}
      </ul>
   </nav>
</footer>
