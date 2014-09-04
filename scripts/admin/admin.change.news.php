<?php
require_once CLASSES_ROOT  . 'class.News.php';
require_once CLASSES_ROOT  . 'class.Department.php';
require_once HANDLERS_ROOT . 'handler.php';

$vars['head'] = $vars['body'] = $vars['date'] = $vars['desc'] = $vars['mtitle'] = $vars['mkeywords'] = $vars['mdescription'] = $vars['cats'] = null;

if ($request->get('mode')) {
   $vars['head']         = $request->get('head');
   $vars['body']         = $request->get('body');
   $vars['desc']         = $request->get('desc');
   $vars['cats']         = $request->get('categories', []);
   $vars['date']         = $request->get('date');
   $vars['mtitle']       = $request->get('title');
   $vars['mkeywords']    = $request->get('keywords');
   $vars['mdescription'] = $request->get('description');
   HandleAdminData($_news->SetCategories($vars['cats']), [
      'mode'   => $request->get('mode'),
      'params' => [
         News::ID_FLD               => $request->get('id'),
         News::TEXT_HEAD_FLD        => $vars['head'],
         News::TEXT_BODY_FLD        => $vars['body'],
         News::DESCRIPTION_FLD      => $vars['desc'],
         News::TITLE_FLD            => $vars['mtitle'],
         News::KEYWORDS_FLD         => $vars['mkeywords'],
         News::META_DESCRIPTION_FLD => $vars['mdescription'],
         News::PUBLICATION_DATE_FLD => DateToMySqlDate($vars['date'])
      ]
   ], 'news');
}

$smarty->assign($vars)
       ->assign('departments', $_department->SetSamplingScheme(Department::SHORT_INFO_SCHEME)->GetAll())
       ->display('admin.change.news.tpl');
