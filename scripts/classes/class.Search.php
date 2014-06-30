<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.SQL.php';

class Search
{
   private
      $table,
      $limit,
      $joins,
      $params,
      $clause,
      $joinFields,
      $joinParams,
      $limitParams,
      $isChangeJoin = true;


   public function __construct(
      $table,
      $clause       = null,
      $joinFields   = Array(),
      $joinParams   = Array(),
      $limitParams  = Array()
   )
   {
      $this->table        = $table;
      $this->clause       = !empty($clause) ? $clause : new Clause();
      $this->limitParams  = $limitParams;
      $this->joinFields   = $joinFields;
      $this->joinParams   = $joinParams;
   }

   public function GetClause()
   {
      return $this->clause->GetClause();
   }

   public function GetJoins()
   {
      if ($this->isChangeJoin) {
         $this->joins        = SQL::MakeJoin($this->table, $this->joinFields);
         $this->isChangeJoin = false;
      }
      return $this->joins;
   }

   public function GetParams()
   {
      return array_merge($this->clause->GetParams(), $this->joinParams, $this->limitParams);
   }

   public function GetLimit()
   {
      return !empty($this->limitParams);
   }

   public function GetLimitAmount()
   {
      return !empty($this->limitParams) ? $this->limitParams[1] : -1;
   }

   public function SetJoins($joinFields = [], $joinParams = [])
   {
      $this->joinFields   = $joinFields;
      $this->joinParams   = $joinParams;
      return $this;
   }

   public function AddLimit($amount, $curPage)
   {
      $this->limitParams   = Array();
      $this->limitParams[] = $curPage;
      $this->limitParams[] = $amount;
      return $this;
   }

   public function AddClause($cond)
   {
      $this->clause->AddClause($cond);
      return $this;
   }

   public function RemoveClause()
   {
      $this->clause->RemoveClause();
      return $this;
   }

}

class OrderField
{
   private
      $field;

   public
      $table;

   public function __construct($table, $field)
   {
      $this->table = $table;
      $this->field = $field;
   }

   public function GetFieldName()
   {
      return $this->field->GetName();
   }
}

class Order
{
   private
      $fields = Array();

   public function AddField($fInfo, $orderType)
   {
      foreach ($this->fields as &$field) {
         if ($field['info']->GetFieldName() == $fInfo->GetFieldName()) {
            $field['type'] = $orderType;
            return;
         }
      }
      $this->fields[] = Array(
         'info' => $fInfo,
         'type' => $orderType
      );
   }

   public function GetOrder()
   {
      $result = '';
      $amount = count($this->fields);
      foreach ($this->fields as $key => $field) {
         $result .= (!empty($field['info']) ? SQL::ToTblNm($field['info']->table, $field['info']->GetFieldName()) : '')
                  . ' '
                  . $field['type']
                  . ($key < $amount - 1 ? ', ' : '');
      }
      return $result;
   }
}
