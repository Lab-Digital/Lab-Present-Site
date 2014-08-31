<?php
require_once CLASSES_ROOT . 'class.TextsBase.php';
require_once CLASSES_ROOT . 'class.TableImages.php';

class Project extends TextsBase
{
   const MAIN_SCHEME    = 2;
   const PROJECT_SCHEME = 3;

   const TABLE = 'projects';

   const LAST_VIEWED_ID = 'last_viewed_project_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields[] = new Field(
         static::DESCRIPTION_FLD,
         StrType(MAX_SHORT_DESC_LEN, 'Описание проекта не может превышать ' . MAX_SHORT_DESC_LEN . ' символов.'),
         true,
         'Описание проекта',
         [Validate::IS_NOT_EMPTY]
      );
      $this->GetFieldByName(static::TEXT_HEAD_FLD)->SetAlias('Название проекта');
      $this->GetFieldByName(static::TEXT_BODY_FLD)->SetAlias('Текст про проект');
   }

   public function SetSelectValues()
   {
      switch ($this->samplingScheme) {
         case static::MAIN_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(
               static::TABLE,
               [$this->urlField, $this->GetFieldByName(static::TEXT_HEAD_FLD), $this->GetFieldByName(static::DESCRIPTION_FLD)]
            );
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
            $this->_NotNullImageClause(static::AVATAR_FLD);
            break;

         case static::PROJECT_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [
               $this->urlField,
               $this->GetFieldByName(static::TITLE_FLD),
               $this->GetFieldByName(static::TEXT_HEAD_FLD),
               $this->GetFieldByName(static::TEXT_BODY_FLD),
               $this->GetFieldByName(static::KEYWORDS_FLD),
               $this->GetFieldByName(static::META_DESCRIPTION_FLD)
            ]);
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
            break;

         default:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
            break;
      }
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   public function ModifySample(&$sample)
   {
      if (empty($sample)) return;
      switch ($this->samplingScheme) {
         case static::MAIN_SCHEME:
            ModifySampleWithImage($sample, [$this->ToPrfxNm(static::AVATAR_FLD)]);
            break;

         case static::PROJECT_SCHEME:
            ModifySampleWithImage($sample, [$this->ToPrfxNm(static::PHOTO_FLD)]);
            break;

         default:
            ModifySampleWithImage($sample, [$this->ToPrfxNm(static::PHOTO_FLD), $this->ToPrfxNm(static::AVATAR_FLD)]);
            break;
      }
   }

   protected function GetURLBase()
   {
      return $this->GetFieldByName(static::TEXT_HEAD_FLD)->GetValue();
   }

}

$_project = new Project();
