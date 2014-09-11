<?php
require_once CLASSES_ROOT  . 'class.Meta.php';
require_once HANDLERS_ROOT . 'handler.php';

SetLastViewedID(Meta::LAST_VIEWED_ID);

$vars['meta_title'] = $vars['meta_keywords'] = $vars['meta_description'] = null;

if ($request->get('mode')) {
   $id                       = $request->get('id');
   $vars['meta_title']       = $request->get('title');
   $vars['meta_keywords']    = $request->get('keywords');
   $vars['meta_description'] = $request->get('description');
   $_meta->SetLastViewedID($id);
   HandleAdminData($_meta, [
      'mode'   => 'Update',
      'params' => [
         Meta::ID_FLD          => $id,
         Meta::TITLE_FLD       => $vars['meta_title'],
         Meta::KEYWORDS_FLD    => $vars['meta_keywords'],
         Meta::DESCRIPTION_FLD => $vars['meta_description']
      ]
   ], 'meta');
   SetLastViewedID(Meta::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('meta', $_meta->SetSamplingScheme(Meta::ADMIN_SCHEME)->GetAll())
       ->display('admin.meta.tpl');
