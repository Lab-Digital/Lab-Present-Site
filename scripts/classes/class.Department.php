<?php
require_once CLASSES_ROOT . 'class.TextsBase.php';
require_once CLASSES_ROOT . 'class.TableImages.php';

class Department extends TextsBase
{
   const PHOTO_FLD = 'photo_id';

   const TABLE = 'departments';

   const LAST_VIEWED_ID = 'last_viewed_department_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields = array_merge($this->texts_fields, [new Field(static::PHOTO_FLD,  IntType(), true)]);
   }

   public function SetSelectValues()
   {
      $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
      $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
      $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   protected function GetURLBase()
   {
      return $this->GetFieldByName(static::TEXT_HEAD_FLD)->GetValue();
   }

}

$_department = new Department();
