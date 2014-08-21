<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.News.php';

try {
   // $handler = (new ProposalHandler())->Handle(GetPOST());
   $ajaxResult['pages_amount'] = News::NEWS_ON_INDEX_PAGE != 0 ? ceil($_news->GetAllAmount() / News::NEWS_ON_INDEX_PAGE) : 0;
   $ajaxResult['news'] = $_news->SetSamplingScheme(News::MAIN_SCHEME)->GetNews(!empty($_POST['page']) ? $_POST['page'] : 0, News::NEWS_ON_INDEX_PAGE);
} catch (Exception $e) {
   $ajaxResult['result'] = false;
   $ajaxResult['message'] = $e->getMessage();
}

echo json_encode($ajaxResult);
