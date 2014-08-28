<?php
require_once CLASSES_ROOT . 'class.Entity.php';

class Meta extends Entity
{
   const INDEX_META_ID    = 1;
   const NEWS_META_ID     = 2;
   const RESUME_META_ID   = 3;
   const CONTACTS_META_ID = 4;

   const PAGE_SCHEME  = 2;
   const ADMIN_SCHEME = 3;

   const HEAD_FLD        = 'head';
   const TITLE_FLD       = 'title';
   const KEYWORDS_FLD    = 'keywords';
   const DESCRIPTION_FLD = 'description';

   const TABLE = 'meta';

   const LAST_VIEWED_ID = 'last_viewed_meta_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::KEYWORDS_FLD,
            TextType(),
            true
         ),
         new Field(
            static::DESCRIPTION_FLD,
            TextType(),
            true
         ),
         new Field(
            static::TITLE_FLD,
            StrType(200),
            true,
            'Title страницы',
            [Validate::IS_NOT_EMPTY]
         ),
         new Field(
            static::HEAD_FLD,
            StrType(130),
            false
         )
      );
      $this->orderFields = [static::ID_FLD => new OrderField(static::TABLE, $this->idField)];
   }

   public function SetSelectValues()
   {
      $fields = [];
      switch ($this->samplingScheme) {
         case static::PAGE_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [
               $this->GetFieldByName(static::TITLE_FLD),
               $this->GetFieldByName(static::KEYWORDS_FLD),
               $this->GetFieldByName(static::DESCRIPTION_FLD)
            ]);
            break;

         case static::ADMIN_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
            break;
      }
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   public function GetAll()
   {
      $this->AddOrder(static::ID_FLD);
      return parent::GetAll();
   }

}

$_meta = new Meta();
