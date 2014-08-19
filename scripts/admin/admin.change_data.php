<?php
require_once HANDLERS_ROOT . 'handler.php';

if ($request->get('mode')) {
   $_admin->ChangeData(
      $request->get('login'),
      $request->get('pass'),
      $request->get('new_pass')
   );
}
$smarty->assign('admin', $_admin->GetById(ADMIN_ID))
       ->display('admin.change_data.tpl');
