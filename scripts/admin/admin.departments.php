<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Department.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.php';

SetLastViewedID(Department::LAST_VIEWED_ID);

$vars['head'] = $vars['body'] = $vars['mtitle'] = $vars['mkeywords'] = $vars['mdescription'] = null;

if ($request->get('mode')) {
   $id                   = $request->get('id');
   $vars['head']         = $request->get('head');
   $vars['body']         = $request->get('body');
   $vars['mtitle']       = $request->get('title');
   $vars['mkeywords']    = $request->get('keywords');
   $vars['mdescription'] = $request->get('description');
   $_department->SetLastViewedID($id);
   HandleAdminData($_department, [
      'mode' => $request->get('mode'),
      'params' => [
         Department::ID_FLD               => $id,
         Department::TITLE_FLD            => $vars['mtitle'],
         Department::KEYWORDS_FLD         => $vars['mkeywords'],
         Department::TEXT_BODY_FLD        => $vars['body'],
         Department::TEXT_HEAD_FLD        => $vars['head'],
         Department::META_DESCRIPTION_FLD => $vars['mdescription']
      ]
   ], 'departments');
   SetLastViewedID(Department::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('isInsert', $request->get('mode') == 'Insert')
       ->assign('item_id', $request->query->get('item_id'))
       ->assign('departments', $_department->GetAll())
       ->display("admin.departments.tpl");
