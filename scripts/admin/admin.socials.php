<?php
require_once CLASSES_ROOT  . 'class.Socials.php';
require_once HANDLERS_ROOT . 'handler.php';

SetLastViewedID(Socials::LAST_VIEWED_ID);

$vars['url'] = $vars['head'] = null;

if ($request->get('mode')) {
   $id           = $request->get('id');
   $vars['url']  = $request->get('url');
   $vars['head'] = $request->get('head');
   $_socials->SetLastViewedID($id);
   HandleAdminData($_socials, [
      'mode'   => $request->get('mode'),
      'params' => [
         Socials::ID_FLD   => $id,
         Socials::URL_FLD  => $vars['url'],
         Socials::HEAD_FLD => $vars['head']
      ]
   ], 'socials');
   SetLastViewedID(Socials::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('isInsert', $request->get('mode') == 'Insert')
       ->assign('item_id', $request->query->get('item_id'))
       ->assign('socials', $_socials->GetAll())
       ->display('admin.socials.tpl');
