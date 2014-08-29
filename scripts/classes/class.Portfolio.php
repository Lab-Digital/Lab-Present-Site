<?php
require_once CLASSES_ROOT . 'class.Image.php';
require_once CLASSES_ROOT . 'class.PortfolioDepartments.php';

class Portfolio extends Entity
{
   const INFO_SCHEME         = 2;
   const GRID_SCHEME         = 3;
   const ADMIN_INFO_SCHEME   = 4;
   const ADMIN_CHANGE_SCHEME = 5;

   const HEAD_FLD        = 'head';
   const PHOTO_FLD       = 'photo_id';
   const AVATAR_FLD      = 'avatar_id';
   const CATEGORIES_FLD  = 'categories';
   const DESCRIPTION_FLD = 'description';

   const TABLE = 'portfolio';

   const ADMIN_AMOUNT = 20;

   private $categories;

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
            TextType(),
            true
         ),
         new Field(
            static::AVATAR_FLD,
            IntType(),
            true
         ),
         new Field(
            static::PHOTO_FLD,
            IntType(),
            true
         )
      );
   }

   public function SetCategories($categories)
   {
      $this->categories = $categories;
      return $this;
   }

   private function _NotNullImageClause($fieldName)
   {
      $this->CheckSearch()->search->AddClause(CCond(
         CF(static::TABLE, $this->GetFieldByName($fieldName)),
         CVS('NULL'),
         cAND,
         'IS NOT'
      ));
      return $this;
   }

   public function GetAllAmountWithPhoto()
   {
      $this->_NotNullImageClause(staitc::PHOTO_FLD)->_NotNullImageClause(staitc::AVATAR_FLD);
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

   public function SetSelectValues()
   {
      $fields = [];
      switch ($this->samplingScheme) {
         case static::GRID_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [$this->idField]);
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
            $this->_NotNullImageClause(static::AVATAR_FLD);
            break;

         case static::ADMIN_INFO_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [
               $this->idField,
               $this->GetFieldByName(static::HEAD_FLD),
               $this->GetFieldByName(static::DESCRIPTION_FLD)
            ]);
            $fields[] = $this->_SelectCategories();
            break;

         case static::ADMIN_CHANGE_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [
               $this->idField,
               $this->GetFieldByName(static::HEAD_FLD),
               $this->GetFieldByName(static::DESCRIPTION_FLD)
            ]);
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::AVATAR_FLD));
            $fields[] = $this->_SelectCategories();
            break;

      }
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   public function GetDepartmentPortfolio($department_id)
   {
      $this->CreateSearch()->search->SetJoins([PortfolioDepartments::TABLE => [null, [static::ID_FLD, PortfolioDepartments::PORTFOLIO_FLD]]]);
      global $_portfolioDepartments;
      $this->search->AddClause(CCond(
         CF(PortfolioDepartments::TABLE, $_portfolioDepartments->GetFieldByName(PortfolioDepartments::DEPARTMENT_FLD)),
         CVP($department_id)
      ));
      return $this->SetSamplingScheme(static::GRID_SCHEME)->GetAll();
   }

   private function _SelectCategories()
   {
      global $_portfolioDepartments;
      return sprintf(
         "IFNULL((SELECT GROUP_CONCAT(%s) FROM %s WHERE %s GROUP BY %s), '') as %s",
         $_portfolioDepartments->ToTblNm(PortfolioDepartments::DEPARTMENT_FLD),
         PortfolioDepartments::TABLE,
         (new Clause(CCond(
            CF(PortfolioDepartments::TABLE, $_portfolioDepartments->GetFieldByName(PortfolioDepartments::PORTFOLIO_FLD)),
            CF(static::TABLE, $this->GetFieldByName(static::ID_FLD))
         )))->GetClause(),
         $_portfolioDepartments->ToTblNm(PortfolioDepartments::PORTFOLIO_FLD),
         $this->ToPrfxNm(static::CATEGORIES_FLD)
      );
   }

   public function ModifySample(&$sample)
   {
      if (empty($sample)) return;
      switch ($this->samplingScheme) {
         case static::GRID_SCHEME:
            $avatarField = $this->ToPrfxNm(static::AVATAR_FLD);
            $result = $tmp = [];
            $idx = 1;
            for ($i = 0; $i < count($sample); $i++) {
               ModifySetWithImage($sample[$i], [$avatarField]);
               $tmp[] = $sample[$i];
               if ($idx++ % 4 == 0) {
                  $idx = 1;
                  $result[] = $tmp;
                  $tmp = [];
               }
            }
            if (!empty($tmp)) {
               $result[] = $tmp;
            }
            $sample = $result;
            break;

         case static::ADMIN_INFO_SCHEME:
            $catKey = $this->ToPrfxNm(static::CATEGORIES_FLD);
            foreach ($sample as &$set) {
               $set[$catKey] = !empty($set[$catKey]) ? explode(',', $set[$catKey]) : [];
            }
            break;

         case static::ADMIN_CHANGE_SCHEME:
            $catKey = $this->ToPrfxNm(static::CATEGORIES_FLD);
            foreach ($sample as &$set) {
               $a = [];
               if (!empty($set[$catKey])) {
                  foreach (explode(',', $set[$catKey]) as $category_id) {
                     $a[$category_id] = 1;
                  }
               }
               $set[$catKey] = $a;
               ModifySetWithImage($set, [$this->ToPrfxNm(static::PHOTO_FLD), $this->ToPrfxNm(static::AVATAR_FLD)]);
            }
            break;
      }
   }

   public function Insert($getLastInsertId = false)
   {
      global $db, $_portfolioDepartments;
      try {
         $db->link->beginTransaction();
         $id = parent::Insert(true);
         $_portfolioDepartments->SetFieldByName(PortfolioDepartments::PORTFOLIO_FLD, $id);
         if (!empty($this->categories)) {
            foreach ($this->categories as $category => $value) {
               if ($value) {
                  $_portfolioDepartments->SetFieldByName(PortfolioDepartments::DEPARTMENT_FLD, $category)->Insert();
               }
            }
         }
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
   }

   public function UpdatePhoto($id, $field)
   {
      global $db, $_image;
      try {
         $db->link->beginTransaction();
         $__file = $_image->Insert(true);
         $this->SetFieldByName(static::ID_FLD, $id)->SetFieldByName($field, $__file);
         parent::Update();
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
      return $__file;
   }

   public function Update()
   {
      global $db, $_portfolioDepartments;
      try {
         $db->link->beginTransaction();
         $_portfolioDepartments->SetFieldByName(PortfolioDepartments::PORTFOLIO_FLD, $this->GetFieldByName(static::ID_FLD)->GetValue())
                          ->DeleteByPortfolio();
         foreach ($this->categories as $category => $value) {
            if ($value) {
               $_portfolioDepartments->SetFieldByName(PortfolioDepartments::DEPARTMENT_FLD, $category)->Insert();
            }
         }
         parent::Update();
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
   }

}

$_portfolio = new Portfolio();
