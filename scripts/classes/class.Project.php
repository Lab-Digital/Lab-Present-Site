<?php
require_once CLASSES_ROOT . 'class.TextsBase.php';
require_once CLASSES_ROOT . 'class.TableImages.php';

class Project extends TextsBase
{
   const MAIN_SCHEME = 2;

   const TABLE = 'projects';

   const LAST_VIEWED_ID = 'last_viewed_project_id';

   public function __construct()
   {
      parent::__construct();
      $this->fields = $this->texts_fields;
   }

   public function SetSelectValues()
   {
      if ($this->samplingScheme != static::MAIN_SCHEME) {
         $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
      } else {
         $fields = SQL::PrepareFieldsForSelect(
            static::TABLE,
            [$this->urlField, $this->GetFieldByName(static::TEXT_HEAD_FLD), $this->GetFieldByName(static::TEXT_BODY_FLD)]
         );
         $this->CreateSearch()->search->AddClause(CCond(
            CF(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD)),
            CVS('NULL'),
            '',
            'IS NOT'
         ));
      }
      $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   protected function GetURLBase()
   {
      return $this->GetFieldByName(static::TEXT_HEAD_FLD)->GetValue();
   }

}

$_project = new Project();
