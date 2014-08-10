<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.php';

if ($request->get('mode')) {
   $_admin->ChangeData(
      $request->get('login'),
      $request->get('pass'),
      $request->get('new_pass')
   );
}
$smarty->assign('admin', $_admin->GetById(ADMIN_ID))
       ->display('admin.change_data.tpl');
