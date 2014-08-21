<?php
define('SCRIPTS_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/scripts/');
define('ADMIN_ROOT', SCRIPTS_ROOT . 'admin/');
define('CLASSES_ROOT', SCRIPTS_ROOT . 'classes/');
define('HANDLERS_ROOT', SCRIPTS_ROOT . 'handlers/');

require_once SCRIPTS_ROOT . 'container.php';

switch ($request_parts[0]) {
   case '': case null: case false:
      require_once SCRIPTS_ROOT . 'main.php';
      break;

   case 'departaments':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/departaments.php';
      break;

   case 'news':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/news.php';
      break;
      
   case 'uploadphoto':
      require_once SCRIPTS_ROOT . 'upload_photo.php';
      break;

   case 'uploadimage':
      require_once SCRIPTS_ROOT . 'uploadimage.php';
      break;

   case 'resizeimage':
      require_once SCRIPTS_ROOT . 'resize.php';
      break;

   case 'handler':
      $possible_handlers = [
         'news'     => HANDLERS_ROOT . 'handler.News.php',
         'image'    => HANDLERS_ROOT . 'handler.Image.php'
      ];
      if (empty($request[1]) || empty($possible_handlers[$request[1]])) Redirect('/404');
      require_once $possible_handlers[$request[1]];
      break;

   case 'admin':
      require_once CLASSES_ROOT . 'class.Admin.php';

      $isLoginPage = empty($request_parts[1]) || $request_parts[1] == 'login';
      if ($_admin->IsAdmin()) {
         if ($isLoginPage) {
            Redirect(ADMIN_START_PAGE);
         }
      } elseif (!$isLoginPage) {
         Redirect('/admin/');
      }
      $request_parts[1] = !empty($request_parts[1]) ? $request_parts[1] : null;
      switch ($request_parts[1]) {
         case '': case 'login': case null: case false:
            require_once ADMIN_ROOT . 'admin.login.php';
            break;

         case 'news':
            require_once ADMIN_ROOT . 'admin.news.php';
            break;

         case 'projects':
         case 'departments':
            require_once CLASSES_ROOT . 'class.Project.php';
            require_once CLASSES_ROOT . 'class.Department.php';
            $page = $request_parts[1];
            $obj = $page == 'projects' ? $_project : $_department;
            $smarty->assign('pname', $page == 'projects' ? 'Проект' : 'Отдел');
            require_once ADMIN_ROOT . 'admin.textsbase.php';
            break;

         case 'change_data':
            require_once ADMIN_ROOT . 'admin.change_data.php';
            break;

         case 'meta':
            require_once ADMIN_ROOT . 'admin.meta.php';
            break;

         case 'logout':
            unset($_SESSION['admin_login']);
            unset($_SESSION['admin_pass']);
            Redirect(ADMIN_START_PAGE);
            break;

         case 'add':
            if (empty($request_parts[2])) {
               Redirect(ADMIN_START_PAGE);
            }
            $id = null;
            $smarty->assign('isAdd', true);
            switch ($request_parts[2]) {
               case 'news':
                  $smarty->assign('handle_url', 'add/news');
                  require_once ADMIN_ROOT . 'admin.change.news.php';
                  break;

               default:
                  Redirect(ADMIN_START_PAGE);
                  break;
            }
            break;

         case 'edit':
         case 'delete':
            if (empty($request_parts[2]) || empty($request_parts[3]) || !IsPositiveNumber($request_parts[2])) {
               Redirect(ADMIN_START_PAGE);
            }
            $id = $request_parts[2];
            switch ($request_parts[3]) {
               case 'news':
                  if ($request_parts[1] == 'delete') {
                     $request->request->set('id', $id);
                     $request->request->set('mode', 'Delete');
                  }
                  require_once CLASSES_ROOT . 'class.News.php';
                  $data = $_news->GetById($id);
                  if (empty($data)) Redirect('/admin/add/news');
                  $smarty->assign('article', $data)->assign('handle_url', "edit/$id/news");
                  require_once ADMIN_ROOT . 'admin.change.news.php';
                  break;

               default:
                  Redirect(ADMIN_START_PAGE);
                  break;
            }
            break;

         default:
            Redirect(ADMIN_START_PAGE);
            break;
      }
      break;

   default:
      echo "FAIL ERROR";
      #error page
}
