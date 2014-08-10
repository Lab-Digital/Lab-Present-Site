<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/container.php';

switch ($request_parts[0]) {
   case '': case null: case false:
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/main.php';
      break;

   case 'uploadphoto':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/upload_photo.php';
      break;

   case 'uploadimage':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/uploadimage.php';
      break;

   case 'resizeimage':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/resize.php';
      break;

   case 'handler':
      $possible_handlers = [
         'news'     => $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.News.php',
         'image'    => $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.Image.php'
      ];
      if (empty($request[1]) || empty($possible_handlers[$request[1]])) Redirect('/404');
      require_once $possible_handlers[$request[1]];
      break;

   case 'admin':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Admin.php';

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
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.login.php';
            break;

         case 'news':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.news.php';
            break;

         case 'departments':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.departments.php';
            break;

         case 'change_data':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.change_data.php';
            break;

         case 'meta':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.meta.php';
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
                  require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.change.news.php';
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
                  require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.News.php';
                  $data = $_news->GetById($id);
                  if (empty($data)) Redirect('/admin/add/news');
                  $smarty->assign('article', $data)->assign('handle_url', "edit/$id/news");
                  require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.change.news.php';
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
