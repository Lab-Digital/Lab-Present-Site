<?php
require_once CLASSES_ROOT . 'class.News.php';
require_once CLASSES_ROOT . 'class.Department.php';

list($curPage, $pagesDesc) = $_news->GeneratePages(
   $_news->SetSamplingScheme(News::ADMIN_INFO_SCHEME)->GetAllAmount(), News::NEWS_ON_ADMIN_PAGE
);

$smarty->assign('curPage', $curPage + 1)
       ->assign('pagesInfo', $pagesDesc)
       ->assign('departments', $_department->SetSamplingScheme(Department::ADMIN_NEWS_SCHEME)->GetAll())
       ->assign('news', $_news->GetNews($curPage, News::NEWS_ON_ADMIN_PAGE))
       ->display('admin.news.tpl');
