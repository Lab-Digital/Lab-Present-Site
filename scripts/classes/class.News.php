<?php
require_once CLASSES_ROOT . 'class.EntityURL.php';
require_once CLASSES_ROOT . 'class.TableImages.php';

class News extends EntityURL
{
   const INFO_SCHEME       = 2;
   const MAIN_SCHEME       = 3;
   const ARTICLE_SCHEME    = 4;
   const ADMIN_INFO_SCHEME = 5;

   const PHOTO_FLD            = 'photo_id';
   const TITLE_FLD            = 'meta_title';
   const PHOTOS_FLD           = 'photos';
   const KEYWORDS_FLD         = 'meta_keywords';
   const TEXT_HEAD_FLD        = 'head';
   const TEXT_BODY_FLD        = 'body';
   const DESCRIPTION_FLD      = 'description';
   const PUBLICATION_DATE_FLD = 'publication_date';
   const META_DESCRIPTION_FLD = 'meta_description';

   const TABLE = 'news';

   const LAST_VIEWED_ID = 'last_viewed_news_id';

   const SEE_ALSO_AMOUNT = 3;
   const NEWS_ON_INDEX_PAGE = 4;
   const NEWS_ON_ADMIN_PAGE = 1;

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

   public function ModifySample(&$sample)
   {
      if (empty($sample)) return $sample;
      switch ($this->samplingScheme) {
         case static::MAIN_SCHEME:
         case static::INFO_SCHEME:
         case static::ARTICLE_SCHEME:
            $key = $this->ToPrfxNm(static::PHOTOS_FLD);
            $dateKey = $this->ToPrfxNm(static::PUBLICATION_DATE_FLD);
            foreach ($sample as &$set) {
               $date_var = new DateTime($set[$dateKey]);
               $set[$dateKey] = $date_var->format('d-m-Y');
               if ($this->samplingScheme == static::INFO_SCHEME) {
                  $set[$key] = !empty($set[$key]) ? explode(',', $set[$key]) : Array();
               }
            }
            break;
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
                     $this->GetFieldByName(static::PHOTO_FLD),
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
                  $this->GetFieldByName(static::META_DESCRIPTION_FLD),
                  $this->GetFieldByName(static::PHOTO_FLD)
               ]
            );
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
            break;

         case static::ADMIN_INFO_SCHEME:
            $fields = SQL::PrepareFieldsForSelect(static::TABLE, $this->fields);
            break;

      }
      $fields[] = ImageWithFlagSelectSQL(static::TABLE, $this->GetFieldByName(static::PHOTO_FLD));
      $this->selectFields = SQL::GetListFieldsForSelect($fields);
   }

   public function CreateOtherNewsSearch($id, $categories = [])
   {
      $this->CreateSearch()->SetSamplingScheme(static::MAIN_SCHEME);
      $this->search->AddClause(CCond(
         CF(static::TABLE, $this->idField),
         CVP($id),
         cAND,
         opNE
      ));
      foreach ($categories as $category) {
         // $this->search->AddClause(CCond(
         //    CF(statitc::TABLE, $this->GetFieldByName()),
         //    CVP($id),
         //    cOR,
         // ));
      }
      $this->AddLimit(static::SEE_ALSO_AMOUNT);
      return $this;
   }

   protected function GetURLBase()
   {
      return $this->GetFieldByName(static::TEXT_HEAD_FLD)->GetValue();
   }

   public function GeneratePages($amount)
   {
      list($pageNum, $pagesInfo) = _GeneratePages($this->GetAllAmount(), $amount);
      return [$pageNum, $pagesInfo];
   }

   public function GetNews($page, $amount)
   {
      return $this->AddLimit($amount, $page * $amount)->GetAll();
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
