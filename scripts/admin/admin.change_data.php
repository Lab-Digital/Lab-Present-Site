<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.php';

if (isset($_POST['mode'])) {
   $post = GetPOST();
   $_admin->ChangeData(
      isset($post['login'])     ? $post['login']     : '',
      isset($post['pass'])      ? $post['pass']      : '',
      isset($post['new_pass'])  ? $post['new_pass']  : ''
   );
}
$smarty->assign('admin', $_admin->GetById(ADMIN_ID))
       ->display('admin.change_data.tpl');
