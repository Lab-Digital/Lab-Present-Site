<?php
require_once CLASSES_ROOT  . 'class.Portfolio.php';
require_once HANDLERS_ROOT . 'handler.php';

$vars['head'] = $vars['desc'] = null;

if ($request->get('mode')) {
   $vars['head']         = $request->get('head');
   $vars['desc']         = $request->get('desc');
   HandleAdminData($_portfolio, [
      'mode'   => $request->get('mode'),
      'params' => [
         Portfolio::ID_FLD          => $request->get('id'),
         Portfolio::HEAD_FLD        => $vars['head'],
         Portfolio::DESCRIPTION_FLD => $vars['desc']
      ]
   ], 'portfolio');
}

$smarty->assign($vars)->display('admin.change.portfolio.tpl');
