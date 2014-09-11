<?php
require_once CLASSES_ROOT  . 'class.Settings.php';
require_once HANDLERS_ROOT . 'handler.php';

if ($request->get('mode')) {
   HandleAdminData($_settings, [
      'mode'   => 'Update',
      'params' => [
         Settings::ID_FLD   => Settings::SOCIAL_ID,
         Settings::FLAG_FLD => $request->get('is_visible', 0)
      ]
   ], 'other');
}

$smarty->assign('setting', $_settings->GetById(Settings::SOCIAL_ID))->display('admin.other.tpl');
