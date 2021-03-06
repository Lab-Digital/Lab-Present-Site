<?php
require_once CLASSES_ROOT . 'class.TextsBase.php';
require_once CLASSES_ROOT . 'class.TableImages.php';

class Department extends TextsBase
{
   const MAIN_SCHEME       = 2;
   const SHORT_INFO_SCHEME = 3;
   const ADMIN_NEWS_SCHEME = 4;

   const TABLE = 'departments';

   const LAST_VIEWED_ID = 'last_viewed_department_id';

   public function __construct()
   {
      parent::__construct();
      $this->GetFieldByName(static::TEXT_HEAD_FLD)->SetAlias('Название отдела');
      $this->GetFieldByName(static::TEXT_BODY_FLD)->SetAlias('Текст про отдел');
   }

   public function SetSelectValues()
   {
      switch ($this->samplingScheme) {
         case static::MAIN_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [
               $this->idField, $this->urlField, $this->urlField, $this->GetFieldByName(static::TEXT_HEAD_FLD)
            ]);
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
            break;

         case static::SHORT_INFO_SCHEME:
         case static::ADMIN_NEWS_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [$this->idField, $this->GetFieldByName(static::TEXT_HEAD_FLD)]);
            break;

         default:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
            break;
      }
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   public function ModifySample(&$sample)
   {
      if (empty($sample)) return;
      switch ($this->samplingScheme) {
         case static::ADMIN_NEWS_SCHEME:
            $a = [];
            $idKey = $this->ToPrfxNm(static::ID_FLD);
            $headKey = $this->ToPrfxNm(static::TEXT_HEAD_FLD);
            foreach ($sample as &$set) {
               $a[$set[$idKey]] = $set[$headKey];
            }
            $sample = $a;
            break;

         case static::MAIN_SCHEME:
            ModifySampleWithImage($sample, [$this->ToPrfxNm(static::AVATAR_FLD)]);
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

$_department = new Department();
