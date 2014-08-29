<?php
require_once CLASSES_ROOT . 'class.EntityURL.php';
require_once CLASSES_ROOT . 'class.NewsDepartments.php';
require_once CLASSES_ROOT . 'class.TableImages.php';

class News extends EntityURL
{
   const INFO_SCHEME         = 2;
   const MAIN_SCHEME         = 3;
   const ARTICLE_SCHEME      = 4;
   const ADMIN_INFO_SCHEME   = 5;
   const WATH_OTHER_SCHEME   = 6;
   const ADMIN_CHANGE_SCHEME = 7;

   const PHOTO_FLD            = 'photo_id';
   const BIG_PHOTO_FLD        = 'bigphoto_id';
   const OTHER_PHOTO_FLD      = 'other_photo_id';
   const TITLE_FLD            = 'meta_title';
   const PHOTOS_FLD           = 'photos';
   const KEYWORDS_FLD         = 'meta_keywords';
   const TEXT_HEAD_FLD        = 'head';
   const TEXT_BODY_FLD        = 'body';
   const CATEGORIES_FLD       = 'categories';
   const DESCRIPTION_FLD      = 'description';
   const PUBLICATION_DATE_FLD = 'publication_date';
   const META_DESCRIPTION_FLD = 'meta_description';

   const TABLE = 'news';

   const LAST_VIEWED_ID = 'last_viewed_news_id';

   const SEE_ALSO_AMOUNT = 3;
   const NEWS_ON_INDEX_PAGE = 4;
   const NEWS_ON_DEPARTMENT_PAGE = 3;
   const NEWS_ON_ADMIN_PAGE = 20;
   const NEWS_ON_ALLNEWS_PAGE = 5;

   private $categories;

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
            'Заголовок новости',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::TEXT_BODY_FLD,
            TextType(),
            true,
            'Текст новости',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::DESCRIPTION_FLD,
            StrType(MAX_SHORT_DESC_LEN, 'Описание новости не может превышать ' . MAX_SHORT_DESC_LEN . ' символов.'),
            true,
            'Описание новости',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::PUBLICATION_DATE_FLD,
            TimestampType(),
            false
         ),
         new Field(
            static::PHOTO_FLD,
            IntType(),
            true
         ),
         new Field(
            static::OTHER_PHOTO_FLD,
            IntType(),
            true
         ),
         new Field(
            static::BIG_PHOTO_FLD,
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
            Array(Validate::IS_NOT_EMPTY)
         )
      );
      $this->orderFields =
         Array(static::PUBLICATION_DATE_FLD => new OrderField(static::TABLE, $this->GetFieldByName(static::PUBLICATION_DATE_FLD)));
   }

   public function SetCategories($categories)
   {
      $this->categories = $categories;
      return $this;
   }

   private function _NotNullImageClause($field = null)
   {
      $field = !empty($field) ? $field : static::PHOTO_FLD;
      $this->CheckSearch()->search->AddClause(CCond(
         CF(static::TABLE, $this->GetFieldByName($field)),
         CVS('NULL'),
         cAND,
         'IS NOT'
      ));
   }

   public function ModifySample(&$sample)
   {
      if (empty($sample)) return $sample;
      $dateKey = $this->ToPrfxNm(static::PUBLICATION_DATE_FLD);
      switch ($this->samplingScheme) {
         case static::MAIN_SCHEME:
         case static::INFO_SCHEME:
         case static::ARTICLE_SCHEME:
         case static::WATH_OTHER_SCHEME:
            $key = $this->ToPrfxNm(static::PHOTOS_FLD);
            $catKey = $this->ToPrfxNm(static::CATEGORIES_FLD);
            foreach ($sample as &$set) {
               $date_var = new DateTime($set[$dateKey]);
               $set[$dateKey] = $date_var->format('d.m.Y');
               switch ($this->samplingScheme) {
                  case static::INFO_SCHEME:
                     $set[$key] = !empty($set[$key]) ? explode(',', $set[$key]) : Array();
                     break;

                  case static::ARTICLE_SCHEME:
                     $set[$catKey] = explode(',', $set[$catKey]);
                     break;
               }
            }
            break;

         case static::ADMIN_INFO_SCHEME:
            $catKey = $this->ToPrfxNm(static::CATEGORIES_FLD);
            foreach ($sample as &$set) {
               $date_var = new DateTime($set[$dateKey]);
               $set[$dateKey] = $date_var->format('d.m.Y');
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
            }
            ModifySampleWithImage($sample, [
               $this->ToPrfxNm(static::PHOTO_FLD),
               $this->ToPrfxNm(static::BIG_PHOTO_FLD),
               $this->ToPrfxNm(static::OTHER_PHOTO_FLD)
            ]);
            break;
      }
      if ($this->samplingScheme == static::MAIN_SCHEME) {
         $a = [];
         $photoKey = $this->ToPrfxNm(static::PHOTO_FLD);
         foreach ($sample as &$set) {
            if (!empty($set[$photoKey])) {
               $a[] = $set;
            }
         }
         $sample = $a;
         ModifySampleWithImage($sample, [$this->ToPrfxNm(static::PHOTO_FLD)]);
      } elseif ($this->samplingScheme == static::ARTICLE_SCHEME) {
         ModifySampleWithImage($sample, [$this->ToPrfxNm(static::BIG_PHOTO_FLD)]);
      } elseif ($this->samplingScheme == static::WATH_OTHER_SCHEME) {
         ModifySampleWithImage($sample, [$this->ToPrfxNm(static::OTHER_PHOTO_FLD)]);
      }
   }

   public function SetSelectValues()
   {
      $this->AddOrder(static::PUBLICATION_DATE_FLD, OT_DESC);
      if ($this->TryToApplyUsualScheme()) return;
      $fields = Array();
      switch ($this->samplingScheme) {
         case static::INFO_SCHEME:
            global $_newsImages;
            $fields =
               SQL::PrepareFieldsForSelect(
                  static::TABLE,
                  Array(
                     $this->GetFieldByName(static::ID_FLD),
                     $this->GetFieldByName(static::TEXT_HEAD_FLD),
                     $this->GetFieldByName(static::TEXT_BODY_FLD),
                     $this->GetFieldByName(static::DESCRIPTION_FLD),
                     $this->GetFieldByName(static::PUBLICATION_DATE_FLD),
                     $this->GetFieldByName(static::TITLE_FLD),
                     $this->GetFieldByName(static::KEYWORDS_FLD),
                     $this->GetFieldByName(static::META_DESCRIPTION_FLD),
                  )
               );
            $fields[] = ImageSelectSQL($this, $_newsImages, NewsImages::NEWS_FLD);
            break;

         case static::ARTICLE_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(
               static::TABLE,
               [
                  $this->idField,
                  $this->urlField,
                  $this->GetFieldByName(static::TEXT_HEAD_FLD),
                  $this->GetFieldByName(static::TEXT_BODY_FLD),
                  $this->GetFieldByName(static::PUBLICATION_DATE_FLD),
                  $this->GetFieldByName(static::TITLE_FLD),
                  $this->GetFieldByName(static::KEYWORDS_FLD),
                  $this->GetFieldByName(static::META_DESCRIPTION_FLD)
               ]
            );
            $fields[] = $this->_SelectCategories();
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::BIG_PHOTO_FLD));
            break;

         case static::MAIN_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(
               static::TABLE,
               [
                  $this->idField,
                  $this->urlField,
                  $this->GetFieldByName(static::TEXT_HEAD_FLD),
                  $this->GetFieldByName(static::DESCRIPTION_FLD),
                  $this->GetFieldByName(static::PUBLICATION_DATE_FLD)
               ]
            );
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
            $this->_NotNullImageClause();
            break;

         case static::WATH_OTHER_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(
               static::TABLE,
               [
                  $this->idField,
                  $this->urlField,
                  $this->GetFieldByName(static::TEXT_HEAD_FLD),
                  $this->GetFieldByName(static::DESCRIPTION_FLD),
                  $this->GetFieldByName(static::PUBLICATION_DATE_FLD)
               ]
            );
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::OTHER_PHOTO_FLD));
            $this->_NotNullImageClause(static::OTHER_PHOTO_FLD);
            break;

         case static::ADMIN_INFO_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
            $fields[] = $this->_SelectCategories();
            break;

         case static::ADMIN_CHANGE_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, [
               $this->idField,
               $this->urlField,
               $this->GetFieldByName(static::TEXT_HEAD_FLD),
               $this->GetFieldByName(static::TEXT_BODY_FLD),
               $this->GetFieldByName(static::PUBLICATION_DATE_FLD),
               $this->GetFieldByName(static::TITLE_FLD),
               $this->GetFieldByName(static::KEYWORDS_FLD),
               $this->GetFieldByName(static::META_DESCRIPTION_FLD),
               $this->GetFieldByName(static::DESCRIPTION_FLD)
            ]);
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::BIG_PHOTO_FLD));
            $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::OTHER_PHOTO_FLD));
            $fields[] = $this->_SelectCategories();
            break;

      }
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   public function GetAllAmountWithPhoto($field = null)
   {
      $field = !empty($field) ? $field : static::PHOTO_FLD;
      $this->CheckSearch()->_NotNullImageClause($field);
      return $this->GetAllAmount();
   }

   public function GetOtherNews($id, $categories = [])
   {
      $result = [];
      $this->isDistinctSelect = true;
      $this->CreateSearch()->SetSamplingScheme(static::WATH_OTHER_SCHEME);
      $this->search->AddClause(CCond(
         CF(static::TABLE, $this->idField),
         CVP($id),
         cAND,
         opNE
      ));
      $this->search->SetJoins([NewsDepartments::TABLE => [null, [static::ID_FLD, NewsDepartments::NEWS_FLD]]]);
      global $_newsDepartments;
      $departmentFld = $_newsDepartments->GetFieldByName(NewsDepartments::DEPARTMENT_FLD);
      $tmp_department_first = array_shift($categories);
      $tmp_department_last = array_pop($categories);
      if (!empty($tmp_department_first)) {
         $this->search->AddClause(CCond(
            CF(NewsDepartments::TABLE, $departmentFld),
            CVP($tmp_department_first),
            cAND,
            opEQ,
            '(',
            empty($tmp_department_last) ? ')' : ''
         ));
         foreach ($categories as $category) {
            $this->search->AddClause(CCond(
               CF(NewsDepartments::TABLE, $departmentFld),
               CVP($category),
               cOR
            ));
         }
         if (!empty($tmp_department_last)) {
            $this->search->AddClause(CCond(
               CF(NewsDepartments::TABLE, $departmentFld),
               CVP($tmp_department_last),
               cOR,
               opEQ,
               '',
               ')'
            ));
         }
         $result = $this->AddLimit(static::SEE_ALSO_AMOUNT)->GetAll();
      }
      return $result;
   }

   protected function GetURLBase()
   {
      return $this->GetFieldByName(static::TEXT_HEAD_FLD)->GetValue();
   }

   public function GeneratePages($all_amount, $amount)
   {
      list($pageNum, $pagesInfo) = _GeneratePages($all_amount, $amount);
      return [$pageNum, $pagesInfo];
   }

   public function GetNews($page, $amount)
   {
      return $this->AddLimit($amount, $page * $amount)->GetAll();
   }

   private function _SelectCategories()
   {
      global $_newsDepartments;
      return sprintf(
         "IFNULL((SELECT GROUP_CONCAT(%s) FROM %s WHERE %s GROUP BY %s), '') as %s",
         $_newsDepartments->ToTblNm(NewsDepartments::DEPARTMENT_FLD),
         NewsDepartments::TABLE,
         // SQL::MakeJoin(NewsDepartments::TABLE, [static::TABLE => [null, [NewsDepartments::NEWS_FLD, static::ID_FLD]]]),
         (new Clause(CCond(
            CF(NewsDepartments::TABLE, $_newsDepartments->GetFieldByName(NewsDepartments::NEWS_FLD)),
            CF(News::TABLE, $this->GetFieldByName(static::ID_FLD))
         )))->GetClause(),
         $_newsDepartments->ToTblNm(NewsDepartments::NEWS_FLD),
         $this->ToPrfxNm(static::CATEGORIES_FLD)
      );
   }

   public function Insert($getLastInsertId = false)
   {
      global $db, $_newsDepartments;
      try {
         $db->link->beginTransaction();
         $id = parent::Insert(true);
         $_newsDepartments->SetFieldByName(NewsDepartments::NEWS_FLD, $id);
         if (!empty($this->categories)) {
            foreach ($this->categories as $category => $value) {
               if ($value) {
                  $_newsDepartments->SetFieldByName(NewsDepartments::DEPARTMENT_FLD, $category)->Insert();
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
         $this->SetFieldByName(News::ID_FLD, $id)->SetFieldByName($field, $__file);
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
      global $db, $_newsDepartments;
      try {
         $db->link->beginTransaction();
         $_newsDepartments->SetFieldByName(NewsDepartments::NEWS_FLD, $this->GetFieldByName(static::ID_FLD)->GetValue())
                          ->DeleteByNews();
         foreach ($this->categories as $category => $value) {
            if ($value) {
               $_newsDepartments->SetFieldByName(NewsDepartments::DEPARTMENT_FLD, $category)->Insert();
            }
         }
         parent::Update();
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
   }

   public function CreateDepartmentNewsSearch($department_id)
   {
      $this->CreateSearch()->search->SetJoins([NewsDepartments::TABLE => [null, [static::ID_FLD, NewsDepartments::NEWS_FLD]]]);
      global $_newsDepartments;
      $this->search->AddClause(CCond(
         CF(NewsDepartments::TABLE, $_newsDepartments->GetFieldByName(NewsDepartments::DEPARTMENT_FLD)),
         CVP($department_id)
      ));
      return $this;
   }

   public function GetDepartmentNews($department_id)
   {
      list($curPage, $pagesDesc) = $this->GeneratePages(
         $this->CreateDepartmentNewsSearch($department_id)->SetSamplingScheme(static::WATH_OTHER_SCHEME)->GetAllAmountWithPhoto(static::OTHER_PHOTO_FLD),
         News::NEWS_ON_DEPARTMENT_PAGE
      );
      return ['curPage' => $curPage + 1, 'pagesInfo' => $pagesDesc, 'articles' => $this->GetNews($curPage, static::NEWS_ON_DEPARTMENT_PAGE)];
   }

   public function GetAllNews()
   {
      list($curPage, $pagesDesc) = $this->GeneratePages(
         $this->SetSamplingScheme(static::WATH_OTHER_SCHEME)->GetAllAmountWithPhoto(static::OTHER_PHOTO_FLD),
         News::NEWS_ON_ALLNEWS_PAGE
      );
      return ['curPage' => $curPage + 1, 'pagesInfo' => $pagesDesc, 'articles' => $this->GetNews($curPage, static::NEWS_ON_ALLNEWS_PAGE)];
   }

   // public function GetNews($category = null)
   // {
   //    $pageNum = 0;
   //    $pagesInfo = [];

   //    $result = $db->Query(
   //       sprintf('SELECT %s FROM %s %s LIMIT ?, ?', SQL::GetListFieldsForSelect($fields), $from, $profViews),
   //       [$category, $pageNum * static::CATALOG_AMOUNT, static::CATALOG_AMOUNT]
   //    );
   //    // echo sprintf('SELECT %s FROM %s %s LIMIT ?, ?', SQL::GetListFieldsForSelect($fields), $from, $profViews);
   //    if ($page == PHOTOSESSIONS || $page == VIDEOSESSIONS) {
   //       foreach ($result as &$set) {
   //          $this->ConvertDate($set);
   //       }
   //    } else {
   //       global $psCats, $vsCats;
   //       $this->ModifyMainCatalogInfo($result, $page == PHOTOGRAPHS ? $psCats : $vsCats, $specField);
   //    }
   //    return [$pageNum, $pagesInfo, $result];
   // }
}

$_news = new News();
