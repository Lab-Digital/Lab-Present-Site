<?php
require_once CLASSES_ROOT . 'class.Portfolio.php';

$ajaxResult = Array('result' => true, 'message' => 'Операция прошла успешно!');

try {
   $ajaxResult['info'] = $_portfolio->SetSamplingScheme(Portfolio::INFO_SCHEME)->GetById($request->get('id', -1));
} catch (Exception $e) {
   $ajaxResult['result'] = false;
   $ajaxResult['message'] = $e->getMessage();
}

echo json_encode($ajaxResult);
