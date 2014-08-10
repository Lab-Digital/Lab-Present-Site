<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.php';

SetLastViewedID($obj::LAST_VIEWED_ID);

$vars['head'] = $vars['body'] = $vars['mtitle'] = $vars['mkeywords'] = $vars['mdescription'] = null;

if ($request->get('mode')) {
   $id                   = $request->get('id');
   $vars['head']         = $request->get('head');
   $vars['body']         = $request->get('body');
   $vars['mtitle']       = $request->get('title');
   $vars['mkeywords']    = $request->get('keywords');
   $vars['mdescription'] = $request->get('description');
   $obj->SetLastViewedID($id);
   HandleAdminData($obj, [
      'mode' => $request->get('mode'),
      'params' => [
         $obj::ID_FLD               => $id,
         $obj::TITLE_FLD            => $vars['mtitle'],
         $obj::KEYWORDS_FLD         => $vars['mkeywords'],
         $obj::TEXT_BODY_FLD        => $vars['body'],
         $obj::TEXT_HEAD_FLD        => $vars['head'],
         $obj::META_DESCRIPTION_FLD => $vars['mdescription']
      ]
   ], $page);
   SetLastViewedID($obj::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('page', $page)
       ->assign('isInsert', $request->get('mode') == 'Insert')
       ->assign('item_id', $request->query->get('item_id'))
       ->assign($page, $obj->GetAll())
       ->display("admin.$page.tpl");
