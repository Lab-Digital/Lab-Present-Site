<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.IndexMeta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.php';

$vars['meta_title'] = $vars['meta_keywords'] = $vars['meta_description'] = null;

if ($request->get('mode')) {
   $vars['meta_title']       = $request->get('title');
   $vars['meta_keywords']    = $request->get('keywords');
   $vars['meta_description'] = $request->get('description');
   HandleAdminData($_indexMeta, [
      'mode' => $request->get('mode'),
      'params' => [
         IndexMeta::ID_FLD          => IndexMeta::META_ID,
         IndexMeta::TITLE_FLD       => $vars['meta_title'],
         IndexMeta::KEYWORDS_FLD    => $vars['meta_keywords'],
         IndexMeta::DESCRIPTION_FLD => $vars['meta_description']
      ]
   ], 'other');
}

$smarty->assign($vars)
       ->assign('meta', $_indexMeta->GetById(IndexMeta::META_ID))
       ->display('admin.other.tpl');
