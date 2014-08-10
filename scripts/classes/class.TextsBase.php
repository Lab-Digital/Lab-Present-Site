<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.EntityURL.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.TableImages.php';

class TextsBase extends EntityURL
{
   const INFO_SCHEME = 2;

   const TITLE_FLD            = 'meta_title';
   const AVATAR_FLD           = 'avatar_id';
   const KEYWORDS_FLD         = 'meta_keywords';
   const TEXT_HEAD_FLD        = 'head';
   const TEXT_BODY_FLD        = 'body';
   const META_DESCRIPTION_FLD = 'meta_description';

   protected $texts_fields = [];

   public function __construct()
   {
      parent::__construct();
      $this->texts_fields = Array(
         $this->idField,
         $this->urlField,
         new Field(
            static::TEXT_HEAD_FLD,
            StrType(150),
            true,
            'Название отдела',
            [Validate::IS_NOT_EMPTY]
         ),
         new Field(
            static::TEXT_BODY_FLD,
            TextType(),
            true,
            'Описание отдела',
            [Validate::IS_NOT_EMPTY]
         ),
         new Field(
            static::AVATAR_FLD,
            IntType(),
            true
         ),
         new Field(
            static::KEYWORDS_FLD,
            TextType(),
            true
         ),
         new Field(
            static::META_DESCRIPTION_FLD,
            TextType(),
            true
         ),
         new Field(
            static::TITLE_FLD,
            StrType(125),
            true,
            'Title страницы',
            [Validate::IS_NOT_EMPTY]
         )
      );
      $this->orderFields =
         [static::TEXT_HEAD_FLD => new OrderField(static::TABLE, $this->GetFieldByName(static::TEXT_HEAD_FLD))];
   }

   protected function GetURLBase()
   {
      return $this->GetFieldByName(static::TEXT_HEAD_FLD)->GetValue();
   }

}
