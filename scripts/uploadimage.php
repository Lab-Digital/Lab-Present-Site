<?php
if(!isset($_SESSION)) {
   @session_start();
}
$uploaddir  = 'uploads/';
preg_match('/(.*)(\..*)/', basename($_FILES['uploadimage']['name']), $arr);
$ext        = $arr[2];
$filetypes  = Array('.jpg', '.JPG', '.jpeg', '.JPEG');
$ajaxResult = Array('result' => true, 'message' => 'Загрузка прошла успешно!', 'file_tmp' => $_FILES['uploadimage']['name']);
$_POST['__file'] = 'upload';

try {

  if (!in_array($ext, $filetypes)) {
    throw new Exception('Это разрешение не поддерживается. Только JPG.');
  }

  $arr = getimagesize($_FILES['uploadimage']['tmp_name']);
  if ($_POST['width'] && $arr[0] < $_POST['width']) {
    throw new Exception('Ширина изображения меньше допустимой!');
  }

  if ($_POST['height'] && $arr[1] < $_POST['height']) {
    throw new Exception('Высота изображения меньше допустимой!');
  }

  $ajaxResult['width'] = $arr[0];
  $ajaxResult['height'] = $arr[1];

  if ($_FILES['uploadimage']['size'] > $_POST['maxSize']) {
    throw new Exception('Размер изображения превышает максимальный!');
  }

  require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/php_for_upload.php';

  if (!$ajaxOtherResult['result']) {
    throw new Exception($ajaxOtherResult['message']);
  }

  $path = $uploaddir . $_POST['__file'] . '.jpg';
  if (move_uploaded_file($_FILES['uploadimage']['tmp_name'], $path)) {
    $ajaxResult['file'] = $_POST['__file'];
  } else {
    throw new Exception('Ошибка при загрузке файла на сервер!');
  }
} catch (Exception $e) {
  $ajaxResult['result']  = false;
  $ajaxResult['message'] = $e->getMessage();
}

echo json_encode($ajaxResult);
