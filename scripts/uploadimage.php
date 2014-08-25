<?php
use Symfony\Component\HttpFoundation\Response;
$response = new Response('', Response::HTTP_NOT_FOUND, ['Content-Type' => 'text/html']);

preg_match('/(.*)(\..*)/', basename($_FILES['uploadimage']['name']), $arr);
$ext        = strtolower($arr[2]);
$filetypes  = Array('.jpg', '.jpeg', '.png');
$ajaxResult = Array('result' => true, 'message' => 'Загрузка прошла успешно!', 'file_tmp' => $_FILES['uploadimage']['name']);

$__file = null;

try {
   
   if (!in_array($ext, $filetypes)) {
      throw new Exception('Это разрешение не поддерживается. Только JPG и PNG.');
   }

   $ajaxResult['ext'] = $ext;

   $arr = getimagesize($_FILES['uploadimage']['tmp_name']);
   if ($request->get('width') && $arr[0] < $request->get('width')) {
      throw new Exception('Ширина изображения меньше допустимой!');
   }

   if ($request->get('height') && $arr[1] < $request->get('height')) {
      throw new Exception('Высота изображения меньше допустимой!');
   }

   $ajaxResult['width'] = $arr[0];
   $ajaxResult['height'] = $arr[1];

   if ($_FILES['uploadimage']['size'] > $request->get('maxSize')) {
      throw new Exception('Размер изображения превышает максимальный!');
   }

   require_once SCRIPTS_ROOT . 'php_for_upload.php';

   if (!$ajaxOtherResult['result']) {
      throw new Exception($ajaxOtherResult['message']);
   }

   if (!file_exists(UPLOAD_DIR)) {
      mkdir(UPLOAD_DIR);
   }

   $path = UPLOAD_DIR . $__file . $ext;
   if (!move_uploaded_file($_FILES['uploadimage']['tmp_name'], $path)) {
      throw new Exception('Ошибка при загрузке файла на сервер!');
   }

   $ajaxResult['file'] = $__file;

} catch (Exception $e) {
   $ajaxResult['result']  = false;
   $ajaxResult['message'] = $e->getMessage();
}

if ($ajaxResult['result']) {
   $response->setStatusCode(Response::HTTP_OK);
}
$response->setContent(json_encode($ajaxResult))->send();
