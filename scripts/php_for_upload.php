<?php
try {
   require_once CLASSES_ROOT . 'class.TableImages.php';
   $ajaxOtherResult = Array('result' => true, 'message' => 'Загрузка прошла успешно!');
   $item_id = $request->get('item_id');
   switch ($request->get('uploadType')) {
      case 'projects':
      case 'portfolio':
      case 'departments':
      case 'main_slider':
         require_once CLASSES_ROOT . 'class.Project.php';
         require_once CLASSES_ROOT . 'class.Portfolio.php';
         require_once CLASSES_ROOT . 'class.Department.php';
         require_once CLASSES_ROOT . 'class.MainSlider.php';
         $uploadType = $request->get('uploadType');
         if ($uploadType == 'projects') {
            $obj = $_project;
         } elseif ($uploadType == 'departments') {
            $obj = $_department;
         } elseif ($uploadType == 'main_slider') {
            $obj = $_mainSlider;
         } else {
            $obj = $_portfolio;
         }
         if (!empty($request->get('image_id'))) {
            $_image->Delete($request->get('image_id'));
         }
         try {
            $db->link->beginTransaction();
            $__file = $_image->SetFieldByName(Image::EXT_FLD, $ext)->Insert(true);
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
         require_once CLASSES_ROOT . 'class.News.php';
         $_image->SetFieldByName(Image::EXT_FLD, $ext);
         if (!$request->get('isAvatar', false) && !$request->get('isBigphoto', false) && !$request->get('isWatchother', false)) {
            $__file = $_newsImages->SetFieldByName(NewsImages::NEWS_FLD, $item_id)->Insert(true);
         } else {
            $fieldName = News::PHOTO_FLD;
            if ($request->get('isBigphoto', false)) {
               $fieldName = News::BIG_PHOTO_FLD;
            } elseif ($request->get('isWatchother', false)) {
               $fieldName = News::OTHER_PHOTO_FLD;
            }
            $__file = $_news->UpdatePhoto($item_id, $fieldName);
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
