<?php
//$_POST['__file']
try {
  require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/utils.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Image.php';
  $ajaxOtherResult = Array('result' => true, 'message' => 'Загрузка прошла успешно!');
  $post = GetPOST();
  $item_id = $post['item_id'];
  switch ($post['uploadType']) {
   case 'user_av':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.User.php';
      if (!empty($post['image_id'])) {
         $_image->Delete($post['image_id']);
      }
      try {
         $db->link->beginTransaction();
         $_POST['__file'] = $_image->Insert(true);
         $_user->SetFieldByName(User::PHOTO_FLD, $_POST['__file'])->SetFieldByName(User::ID_FLD, $item_id)->Update();
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
      break;

    default:
      $ajaxOtherResult['result'] = false;
      $ajaxOtherResult['message'] = 'Неопознаный тип загрузки!';
      break;
  }
} catch (DBException $e) {
   $ajaxOtherResult['result'] = false;
   $ajaxOtherResult['message'] = 'Ошибка, связанная с базой данных!';
}
