<?php
require_once CLASSES_ROOT  . 'class.Portfolio.php';
require_once CLASSES_ROOT  . 'class.Department.php';
require_once HANDLERS_ROOT . 'handler.php';

$vars['head'] = $vars['desc'] = $vars['cats'] = null;

if ($request->get('mode')) {
   $vars['head'] = $request->get('head');
   $vars['desc'] = $request->get('desc');
   $vars['cats'] = $request->get('categories', []);
   HandleAdminData($_portfolio->SetCategories($vars['cats']), [
      'mode'   => $request->get('mode'),
      'params' => [
         Portfolio::ID_FLD          => $request->get('id'),
         Portfolio::HEAD_FLD        => $vars['head'],
         Portfolio::DESCRIPTION_FLD => $vars['desc']
      ]
   ], 'portfolio');
}

$smarty->assign($vars)
       ->assign('departments', $_department->SetSamplingScheme(Department::SHORT_INFO_SCHEME)->GetAll())
       ->display('admin.change.portfolio.tpl');
