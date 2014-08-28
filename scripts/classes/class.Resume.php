<?php
require_once CLASSES_ROOT . 'class.Entity.php';
require_once CLASSES_ROOT . 'class.Image.php';

class Resume extends Entity
{
   const HEAD_FLD   = 'head';
   const BODY_FLD   = 'body';
   const PHOTO_FLD  = 'photo_id';
   const NUMBER_FLD = 'number';

   const PAGE_SCHEME = 2;

   const TABLE = 'resume';

   const LAST_VIEWED_ID = 'last_viewed_resume_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::HEAD_FLD,
            StrType(200),
            true,
            'Заголовок слайда',
            [Validate::IS_NOT_EMPTY]
         ),
         new Field(
            static::BODY_FLD,
            TextType(),
            true
         ),
         new Field(
            static::NUMBER_FLD,
            IntType(),
            true,
            'Порядковый номер слайда',
            [Validate::IS_NOT_EMPTY, Validate::IS_NUMERIC]
         ),
         new Field(
            static::PHOTO_FLD,
            IntType(),
            true
         ),
      );
      $this->orderFields = [static::NUMBER_FLD => new OrderField(static::TABLE, $this->GetFieldByName(static::NUMBER_FLD))];
   }

   public function SetSelectValues()
   {
      $this->AddOrder(static::NUMBER_FLD);
      $this->selectFields = SQL::GetListFieldsForSelect(array_merge(
         SQL::PrepareFieldsForSelect(static::TABLE, $this->fields),
         [ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD))]
      ));
      if ($this->samplingScheme == static::PAGE_SCHEME) {
         $this->CreateSearch()->search->AddClause(CCond(
            CF(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD)),
            CVS('NULL'),
            cAND,
            'IS NOT'
         ));
      }
   }

   public function ModifySample(&$sample)
   {
      ModifySampleWithImage($sample, [$this->ToPrfxNm(static::PHOTO_FLD)]);
   }

   public function GetAll()
   {
      $this->AddOrder(static::NUMBER_FLD);
      return parent::GetAll();
   }
}

$_resume = new Resume();
