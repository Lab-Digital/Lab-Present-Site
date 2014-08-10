<?php
try {
   require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.TableImages.php';
   $ajaxOtherResult = Array('result' => true, 'message' => 'Загрузка прошла успешно!');
   $item_id = $request->get('item_id');
   switch ($request->get('uploadType')) {
      case 'projects':
      case 'departments':
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Project.php';
      require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Department.php';
      $obj = $request->get('uploadType') == 'projects' ? $_project : $_department;
      if (!empty($request->get('image_id'))) {
         $_image->Delete($request->get('image_id'));
      }
      try {
         $db->link->beginTransaction();
         $__file = $_image->Insert(true);
         $obj->SetFieldByName($obj::ID_FLD, $item_id)
             ->SetFieldByName($request->get('isAvatar', false) ? $obj::AVATAR_FLD : $obj::PHOTO_FLD, $__file)
             ->Update();
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
      break;

      case 'news':
         require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.News.php';
         if ($request->get('isAvatar', false)) {
            $__file = $_newsImages->SetFieldByName(NewsImages::NEWS_FLD, $item_id)->Insert(true);
         } else {
            try {
               $db->link->beginTransaction();
               $__file = $_image->Insert(true);
               $_news->SetFieldByName(News::ID_FLD, $item_id)->SetFieldByName(News::PHOTO_FLD, $__file)->Update();
               $db->link->commit();
            } catch (DBException $e) {
               $db->link->rollback();
               throw new Exception($e->getMessage());
            }
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
