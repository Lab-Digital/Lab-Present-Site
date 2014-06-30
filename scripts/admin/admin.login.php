<?php
if (isset($_POST['submit'])) {
   $login = isset($_POST['login']) ? $_POST['login'] : '';
   $pass  = isset($_POST['pass'])  ? $_POST['pass']  : '';
   if ($_admin->IsAdmin($login, $pass)) {
      Redirect("/admin/{ADMIN_START_PAGE}");
   } else {
      $smarty->assign('invalid_pass', true)
             ->assign('admin_login', $login);
   }
}
$smarty->display('admin.login.tpl');