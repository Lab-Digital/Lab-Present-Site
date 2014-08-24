<?php
require_once CLASSES_ROOT . 'class.Entity.php';

class Portfolio extends Entity
{
   const INFO_SCHEME         = 2;

   const HEAD_FLD        = 'head';
   const AVATAR_FLD      = 'avatar_id';
   const DESCRIPTION_FLD = 'description';

   const TABLE = 'portfolio';

   const ADMIN_AMOUNT = 20;

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::HEAD_FLD,
            StrType(150),
            true,
            'Заголовок портфолио',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::DESCRIPTION_FLD,
            StrType(MAX_SHORT_DESC_LEN, 'Описание портфолио не может превышать ' . MAX_SHORT_DESC_LEN . ' символов.'),
            true,
            'Описание портфолио',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::AVATAR_FLD,
            IntType(),
            true
         )
      );
   }

   private function _NotNullImageClause()
   {
      $this->CreateSearch()->search->AddClause(CCond(
         CF(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD)),
         CVS('NULL'),
         cAND,
         'IS NOT'
      ));
   }

   public function GetAllAmountWithPhoto()
   {
      $this->_NotNullImageClause();
      return $this->GetAllAmount();
   }

   public function GetPortfolio($all_amount, $amount)
   {
      list($pageNum, $pagesInfo) = _GeneratePages($all_amount, $amount);
      return [
         'curPage' => $pageNum + 1,
         'pagesInfo' => $pagesInfo,
         'portfolio' => $this->AddLimit($amount, $pageNum * $amount)->GetAll()
      ];
   }

}

$_portfolio = new Portfolio();
