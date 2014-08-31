<?php
require_once CLASSES_ROOT . 'class.EntityURL.php';
require_once CLASSES_ROOT . 'class.TableImages.php';

class TextsBase extends EntityURL
{
   const INFO_SCHEME = 2;

   const TITLE_FLD            = 'meta_title';
   const PHOTO_FLD            = 'photo_id';
   const AVATAR_FLD           = 'avatar_id';
   const KEYWORDS_FLD         = 'meta_keywords';
   const TEXT_HEAD_FLD        = 'head';
   const TEXT_BODY_FLD        = 'body';
   const DESCRIPTION_FLD      = 'description';
   const META_DESCRIPTION_FLD = 'meta_description';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         $this->urlField,
         new Field(
            static::TEXT_HEAD_FLD,
            StrType(150),
            true,
            '',
            [Validate::IS_NOT_EMPTY]
         ),
         new Field(
            static::TEXT_BODY_FLD,
            TextType(),
            true,
            '',
            [Validate::IS_NOT_EMPTY]
         ),
         new Field(
            static::PHOTO_FLD,
            IntType(),
            true
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
