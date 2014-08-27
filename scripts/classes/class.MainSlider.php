<?php
require_once CLASSES_ROOT . 'class.Entity.php';
require_once CLASSES_ROOT . 'class.Image.php';

class MainSlider extends Entity
{
   const URL_FLD = 'url';
   const NUMBER_FLD = 'number';
   const AVATAR_FLD = 'avatar_id';

   const TABLE = 'main_slider';

   const LAST_VIEWED_ID = 'last_viewed_main_slider_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::URL_FLD,
            StrType(300),
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
            static::AVATAR_FLD,
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
         [ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD))]
      ));
   }

   public function ModifySample(&$sample)
   {
      ModifySampleWithImage($sample, [$this->ToPrfxNm(static::AVATAR_FLD)]);
   }
}

$_mainSlider = new MainSlider();
