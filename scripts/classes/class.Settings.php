<?php
require_once CLASSES_ROOT . 'class.Entity.php';

class Settings extends Entity
{
   const SOCIAL_ID = 1;

   const PAGE_SCHEME = 2;

   const HEAD_FLD = 'head';
   const FLAG_FLD = 'flag';

   const TABLE = 'settings';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::FLAG_FLD,
            IntType(),
            true
         ),
         new Field(
            static::HEAD_FLD,
            StrType(150),
            false
         )
      );
   }

   public function SetSelectValues()
   {
      if ($this->TryToApplyUsualScheme()) return;
      $this->selectFields =
         SQL::GetListFieldsForSelect(SQL::PrepareFieldsForSelect(static::TABLE, [$this->GetFieldByName(static::FLAG_FLD)]));
   }
}

$_settings = new Settings();
