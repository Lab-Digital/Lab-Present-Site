<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Image.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/handlers/handler.php';

use Symfony\Component\HttpFoundation\Response;
$response = new Response('', Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);

class ImageHandler extends Handler
{
   public function __construct()
   {
      $this->entity = new Image();
   }
}

$ajaxResult = Array('result' => true, 'message' => 'Операция прошла успешно!');

try {
   $handler = new ImageHandler();
   $handler->Handle($_POST);
} catch (Exception $e) {
   $ajaxResult['result'] = false;
   $ajaxResult['message'] = $e->getMessage();
}

if ($ajaxResult['result']) {
   $response->setStatusCode(Response::HTTP_OK);
}

$response->setContent(json_encode($ajaxResult))->send();
