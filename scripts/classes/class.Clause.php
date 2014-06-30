<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Field.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.SQLFieldView.php';

class BaseClausePart
{
   public function IsParam()
   {
      return false;
   }
}

class ClauseField extends BaseClausePart
{
   public
      $table,
      $field;

   public function __construct($table, $field)
   {
      $this->table = $table;
      $this->field = $field;
   }

   public function GetSQL()
   {
      return SQL::ToTblNm($this->table, $this->field->GetName());
   }
}

class ClauseValueParam extends BaseClausePart
{
   private $param;

   public function __construct($param)
   {
      $this->param = $param;
   }

   public function IsParam()
   {
      return true;
   }

   public function GetParam()
   {
      return $this->param;
   }

   public function GetSQL()
   {
      return '?';
   }
}

class ClauseValueStrParam extends BaseClausePart
{
   public $param;

   public function __construct($param)
   {
      $this->param = $param;
   }

   public function GetSQL()
   {
      return $this->param;
   }
}

class ClauseCondition extends BaseClausePart
{
   private
      $left,
      $right;

   public
      $lp   = '',
      $rp   = '',
      $op   = opEQ,
      $cond = '';

   public function __construct($left, $right, $cond, $op, $lp, $rp)
   {
      $this->lp    = $lp;
      $this->rp    = $rp;
      $this->op    = $op;
      $this->cond  = $cond;
      $this->left  = $left;
      $this->right = $right;
   }

   public function GetSQL($isCond)
   {
      $cond = $isCond ? $this->cond . ' ' : '';
      return $cond . $this->lp . $this->left->GetSQL($isCond) . ' ' . $this->op . ' ' . $this->right->GetSQL($isCond) . $this->rp;
   }

   public function GetParams()
   {
      $result = Array();
      if ($this->left->IsParam()) {
         $result[] = $this->left->GetParam();
      }
      if ($this->right->IsParam()) {
         $result[] = $this->right->GetParam();
      }
      return $result;
   }
}

class Clause
{
   private
      $clause         = '',
      $clauseParams   = Array(),
      $clauseParts    = Array(),
      $isChangeClause = true;

   public function __construct()
   {
      $conds = func_get_args();
      foreach ($conds as &$cond) {
         $this->AddClause($cond);
      }
   }

   public function AddClause($cond)
   {
      $this->isChangeClause = true;
      $this->clauseParts[] = $cond;
   }

   public function RemoveClause()
   {
      $this->isChangeClause = true;
      array_pop($this->clauseParts);
   }

   public function GetClause()
   {
      if ($this->isChangeClause) {
         $clause = '';
         foreach ($this->clauseParts as $key => $part) {
            $clause .= $part->GetSQL($key != 0) . ' ';
         }
         $this->clause         = $clause;
         $this->isChangeClause = false;
      }
      return $this->clause;
   }

   public function GetParams()
   {
      $this->clauseParams = Array();
      foreach ($this->clauseParts as $part) {
         $this->clauseParams = array_merge($this->clauseParams, $part->GetParams());
      }
      return $this->clauseParams;
   }
}

function CF($table, $field)
{
   return new ClauseField($table, $field);
}

function CVP($param)
{
   return new ClauseValueParam($param);
}

function CVS($param)
{
   return new ClauseValueStrParam($param);
}

function CCond($left, $right, $cond = '', $op = '=', $lp = '', $rp = '')
{
   return new ClauseCondition($left, $right, $cond, $op, $lp, $rp);
}
