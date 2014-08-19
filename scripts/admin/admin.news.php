<?php
require_once CLASSES_ROOT . 'class.News.php';

list($curPage, $pagesDesc) = $_news->SetSamplingScheme(News::ADMIN_INFO_SCHEME)->GeneratePages();

$smarty->assign('curPage', $curPage + 1)
       ->assign('pagesInfo', $pagesDesc)
       ->assign('news', $_news->GetNews($curPage))
       ->display('admin.news.tpl');
