<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.TextsBase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.TableImages.php';

class Project extends TextsBase
{
   const TABLE = 'projects';

   const LAST_VIEWED_ID = 'last_viewed_project_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields = $this->texts_fields;
   }

   public function SetSelectValues()
   {
      $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
      $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   protected function GetURLBase()
   {
      return $this->GetFieldByName(static::TEXT_HEAD_FLD)->GetValue();
   }

}

$_project = new Project();
