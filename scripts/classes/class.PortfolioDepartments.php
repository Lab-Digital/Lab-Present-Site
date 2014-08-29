<?php
require_once CLASSES_ROOT . 'class.Entity.php';

class PortfolioDepartments extends Entity
{
   const PORTFOLIO_FLD  = 'portfolio_id';
   const DEPARTMENT_FLD = 'department_id';

   const TABLE = 'portfolio_departments';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::PORTFOLIO_FLD,
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

   public function DeleteByPortfolio()
   {
      global $db;
      $db->Query(SQL::GetDeleteQuery(static::TABLE, static::PORTFOLIO_FLD), [$this->GetFieldByName(static::PORTFOLIO_FLD)->GetValue()]);
   }

}

$_portfolioDepartments = new PortfolioDepartments();
