<?php
if ($request->get('submit')) {
   $login = $request->get('login');
   $pass  = $request->get('pass');
   if ($_admin->IsAdmin($login, $pass)) {
      Redirect("/admin/{ADMIN_START_PAGE}");
   } else {
      $smarty->assign('invalid_pass', true)
             ->assign('admin_login', $login);
   }
}

$smarty->display('admin.login.tpl');
