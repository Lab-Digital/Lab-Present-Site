<?php
require_once CLASSES_ROOT . 'class.Entity.php';

class NewsDepartments extends Entity
{
   const NEWS_FLD       = 'news_id';
   const DEPARTMENT_FLD = 'department_id';

   const TABLE = 'news_departments';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::NEWS_FLD,
            IntType(),
            true
         ),
         new Field(
            static::DEPARTMENT_FLD,
            IntType(),
            true
         )
      );
   }

   public function DeleteByNews()
   {
      global $db;
      $db->Query(SQL::GetDeleteQuery(static::TABLE, static::NEWS_FLD), [$this->GetFieldByName(static::NEWS_FLD)->GetValue()]);
   }

}

$_newsDepartments = new NewsDepartments();
