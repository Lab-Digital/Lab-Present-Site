<?php
require_once CLASSES_ROOT . 'class.News.php';

list($curPage, $pagesDesc) = $_news->SetSamplingScheme(News::ADMIN_INFO_SCHEME)->GeneratePages(News::NEWS_ON_ADMIN_PAGE);

$smarty->assign('curPage', $curPage + 1)
       ->assign('pagesInfo', $pagesDesc)
       ->assign('news', $_news->GetNews($curPage, News::NEWS_ON_ADMIN_PAGE))
       ->display('admin.news.tpl');
