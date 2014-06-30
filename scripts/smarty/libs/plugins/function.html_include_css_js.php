<?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connect.php');

   function createCSS($page_name)
   {
      global $db_link;
      $st = $db_link->prepare('SELECT css.name FROM css INNER JOIN pages_css
                               ON pages_css.css_id = css.id
                               AND pages_css.page_id = (SELECT id FROM pages WHERE name = :name)');
      $st->bindValue(':name', $page_name);
   }

   function createJS($page_name)
   {
      global $db_link;
      $st = $db_link->prepare('SELECT js.name FROM js INNER JOIN pages_js
                               ON pages_js.js_id = js.id
                               AND pages_js.page_id = (SELECT id FROM pages WHERE name = ?)');
      $st->bindValue(':name', $page_name);
   }

   function smarty_function_html_include_css_js($params, &$smarty)
   {
      $page_name = explode('/', substr($_SERVER['REQUEST_URI'], 1))[0];
      // $js = createJS($page_name);
      // $css = createCSS($page_name);
      return "It's work!!";
   }
?>