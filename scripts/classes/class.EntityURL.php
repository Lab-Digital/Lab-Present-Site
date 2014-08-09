<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/lib/transliteration.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Entity.php';

class EntityURL extends Entity
{
   const URL_FLD = 'url';

   protected $urlField;

   public function __construct()
   {
      parent::__construct();
      $this->urlField = new Field(
         static::URL_FLD,
         StrType(150),
         true,
         'Заголовок',
         [Validate::IS_NOT_EMPTY]
      );
   }

   private function _CreateUrlSearch($url, $isUpdate)
   {
      $this->CreateSearch()->search->AddClause(CCond(
         CF(static::TABLE, $this->GetFieldByName(static::URL_FLD)),
         CVP($url),
         cAND
      ));
      if ($isUpdate) {
         $this->search->AddClause(CCond(
                  CF(static::TABLE, $this->idField),
                  CVP($this->idField->GetValue()),
                  cAND,
                  opNE
         ));
      }
      return $this;
   }

   protected function CheckURL($isUpdate)
   {
      $url = $this->GetFieldByName(static::URL_FLD)->GetValue();
      if (empty($url)) return;
      $part = $this->_CreateUrlSearch($url, $isUpdate)->GetPart();
      $this->CreateSearch();
      if (!empty($part)) {
         throw new Exception('Из данного заголовока невозможно сгенерировать уникальный урл. Измените заголовок.');
      }
   }

   protected function GetURLBase()
   {
      return '';
   }

   private function _GenerateURL($isUpdate = false)
   {
      $base = $this->GetURLBase();
      if (!empty($base)) {
         $this->SetFieldByName(static::URL_FLD, str2url($base))->CheckURL($isUpdate);
      }
      return $this;
   }

   public function Insert($getLastInsertId = false)
   {
      $this->_GenerateURL();
      parent::Insert($getLastInsertId);
   }

   public function Update()
   {
      $this->_GenerateURL(true);
      parent::Update();
   }

   public function GetByURL($url)
   {
      $result = $this->_CreateUrlSearch($url)->GetAll();
      $this->search->RemoveClause();
      return !empty($result[0]) ? $result[0] : [];
   }
}