<?php
require_once CLASSES_ROOT . 'class.Image.php';

class Socials extends Entity
{
   const PAGE_SCHEME = 2;

   const URL_FLD   = 'url';
   const HEAD_FLD  = 'head';
   const PHOTO_FLD = 'photo_id';

   const TABLE = 'socials';

   const LAST_VIEWED_ID = 'last_viewed_socials_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::PHOTO_FLD,
            IntType(),
            true
         ),
         new Field(
            static::HEAD_FLD,
            StrType(150),
            true,
            'Название соц.сети',
            [Validate::IS_NOT_EMPTY]
         ),
         new Field(
            static::URL_FLD,
            StrType(150),
            true,
            'Ссылка на соц.сеть',
            [Validate::IS_NOT_EMPTY]
         )
      );
      $this->orderFields = [static::HEAD_FLD => new OrderField(static::TABLE, $this->GetFieldByName(static::HEAD_FLD))];
   }

   public function SetSelectValues()
   {
      $this->AddOrder(static::HEAD_FLD);
      $fields = SQL::PrepareFieldsForSelect(
         static::TABLE,
         [$this->idField, $this->GetFieldByName(static::HEAD_FLD), $this->GetFieldByName(static::URL_FLD)]
      );
      $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
      if ($this->samplingScheme == static::PAGE_SCHEME) {
         $this->_NotNullImageClause(static::PHOTO_FLD);
      }
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   public function ModifySample(&$sample)
   {
      if (empty($sample)) return;
      ModifySampleWithImage($sample, [$this->ToPrfxNm(static::PHOTO_FLD)]);
   }

}

$_socials = new Socials();
