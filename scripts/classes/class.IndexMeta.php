<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Entity.php';

class IndexMeta extends Entity
{
   const META_ID = 1;

   const TITLE_FLD       = 'title';
   const KEYWORDS_FLD    = 'keywords';
   const DESCRIPTION_FLD = 'description';

   const TABLE = 'index_meta';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::KEYWORDS_FLD,
            TextType(),
            true
         ),
         new Field(
            static::DESCRIPTION_FLD,
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
   }
}

$_indexMeta = new IndexMeta();
