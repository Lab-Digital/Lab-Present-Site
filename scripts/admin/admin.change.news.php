<?php
require_once CLASSES_ROOT  . 'class.News.php';
require_once HANDLERS_ROOT . 'handler.php';

$vars['head'] = $vars['body'] = $vars['desc'] = $vars['mtitle'] = $vars['mkeywords'] = $vars['mdescription'] = null;

if ($request->get('mode')) {
   $vars['head']         = $request->get('head');
   $vars['body']         = $request->get('body');
   $vars['desc']         = $request->get('desc');
   $vars['mtitle']       = $request->get('title');
   $vars['mkeywords']    = $request->get('keywords');
   $vars['mdescription'] = $request->get('description');
   HandleAdminData($_news, [
      'mode'   => $request->get('mode'),
      'params' => [
         News::ID_FLD               => $request->get('id'),
         News::TEXT_HEAD_FLD        => $vars['head'],
         News::TEXT_BODY_FLD        => $vars['body'],
         News::DESCRIPTION_FLD      => $vars['desc'],
         News::TITLE_FLD            => $vars['mtitle'],
         News::KEYWORDS_FLD         => $vars['mkeywords'],
         News::META_DESCRIPTION_FLD => $vars['mdescription']
      ]
   ], 'news');
}

$smarty->assign($vars)->display('admin.change.news.tpl');
