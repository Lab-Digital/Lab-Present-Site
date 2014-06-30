<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/container.php';

switch ($request[0]) {
   case '': case null: case false:
      $smarty->display('index.tpl');
      break;

   case 'admin':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Admin.php';

      $isLoginPage = empty($request[1]) || $request[1] == 'login';
      if ($_admin->IsAdmin()) {
         if ($isLoginPage) {
            Redirect('/admin/' . ADMIN_START_PAGE);
         }
      } elseif (!$isLoginPage) {
         Redirect('/admin/');
      }
      $request[1] = !empty($request[1]) ? $request[1] : null;
      switch ($request[1]) {
         case '': case 'login': case null: case false:
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.login.php';
            break;

         case 'change_data':
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/admin/admin.change_data.php';
            break;

         case 'logout':
            unset($_SESSION['admin_login']);
            unset($_SESSION['admin_pass']);
            header('Location: /admin');
            break;

         default:
            header('Location: /admin/' . ADMIN_START_PAGE);
            break;
      }
      break;

   default:
      echo "FAIL ERROR";
      #error page
}
