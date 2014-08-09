<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Image.php';

class TableImages extends Entity
{
   const PHOTO_FLD  = 'photo_id';

   protected
      $photoField;

   public function __construct()
   {
      parent::__construct();
      $this->photoField = new Field(static::PHOTO_FLD, IntType(), true);
   }

   public function Insert($getLastInsertId = false)
   {
      global $db, $_image;
      $resId = -1;
      try {
         $db->link->beginTransaction();
         $resId = $_image->Insert($getLastInsertId);
         $this->SetFieldByName(static::PHOTO_FLD, $resId);
         Entity::Insert();
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
      return $resId;
   }
}

class NewsImages extends TableImages
{
   const NEWS_FLD  = 'news_id';

   const TABLE = 'news_images';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         $this->photoField,
         new Field(
            static::NEWS_FLD,
            IntType(),
            true
         )
      );
   }
}

$_newsImages   = new NewsImages();
