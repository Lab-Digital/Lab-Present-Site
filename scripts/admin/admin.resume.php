<?php
require_once CLASSES_ROOT  . 'class.Resume.php';
require_once HANDLERS_ROOT . 'handler.php';

SetLastViewedID(Resume::LAST_VIEWED_ID);

$vars['number'] = $vars['head'] = $vars['head'] = null;

if ($request->get('mode')) {
   $id             = $request->get('id');
   $vars['head']   = $request->get('head');
   $vars['body']   = $request->get('body');
   $vars['number'] = $request->get('number');
   $_resume->SetLastViewedID($id);
   HandleAdminData($_resume, [
      'mode' => $request->get('mode'),
      'params' => [
         Resume::ID_FLD     => $id,
         Resume::HEAD_FLD   => $vars['head'],
         Resume::BODY_FLD   => $vars['body'],
         Resume::NUMBER_FLD => $vars['number']
      ]
   ], 'resume');
   SetLastViewedID(Resume::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('isInsert', $request->get('mode') == 'Insert')
       ->assign('item_id', $request->query->get('item_id'))
       ->assign('sliders', $_resume->GetAll())
       ->display('admin.resume.tpl');
