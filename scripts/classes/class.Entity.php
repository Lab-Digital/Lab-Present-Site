<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.SQL.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Field.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Search.php';

class Entity
{
   const TABLE         = '';
   const ID_FLD        = 'id';
   const RAND_FLD      = 'rand';
   const USUAL_SCHEME  = 1;

   const LAST_VIEWED_ID = 'last_viewed_';

   protected
      $idField,
      $selectFields,
      $samplingScheme = self::USUAL_SCHEME;

   public
      $order,
      $search,
      $fields      = Array(),
      $orderFields = Array();


   public function __construct()
   {
      $this->order   = new Order();
      $this->idField = new Field(static::ID_FLD, IntType(), false);
   }

   public function SetFields($params)
   {
      foreach ($params as $name => $value) {
         $this->SetFieldByName($name, $value);
      }
      return $this;
   }

   public function GetAssocValidatedField()
   {
      $result = Array();
      foreach ($this->fields as $field) {
         $result[$field->GetName()] = $field->IsValidated();
      }
      return $result;
   }

   public function SetLastViewedID($id = null)
   {
      if (!empty($id)) {
         $_SESSION[static::LAST_VIEWED_ID] = $id;
      }
   }

   public function SetSamplingScheme($newScheme)
   {
      $this->CheckSearch();
      $this->samplingScheme = $newScheme;
      return $this;
   }

   public function TryToApplyUsualScheme()
   {
      $result = $this->samplingScheme == static::USUAL_SCHEME;
      if ($result) {
         self::SetSelectValues();
      }
      return $result;
   }

   public function ModifySample(&$sample)
   {
   }

   public function AddOrder($fieldName, $orderType = OT_ASC)
   {
      if (array_key_exists($fieldName, $this->orderFields)) {
         $this->order->AddField($this->orderFields[$fieldName], $orderType);
      }
      return $this;
   }

   public function AddLimit($amount, $curPage = 0)
   {
      $this->CheckSearch()->search->AddLimit($amount, $curPage);
      return $this;
   }

   public function GetFieldByName($name)
   {
      foreach ($this->fields as &$f) {
         if ($f->GetName() == $name) {
            return $f;
         }
      }
      return null;
   }

   public function ResetFields()
   {
      foreach ($this->fields as $field) {
         if ($field->canChange) {
            $field->ResetField();
         }
      }
   }

   public function SetFieldByName($name, $value)
   {
      $field = $this->GetFieldByName($name);
      $field->SetValue($value);
      return $this;
   }

   public function GetFieldValueById($id, $name)
   {
      $result = $this->GetById($id);
      return !empty($result) ? $result[$this->ToPrfxNm($name)] : '';
   }

   public function ResetSearch()
   {
      unset($this->search);
      return $this;
   }

   public function CheckSearch()
   {
      if (empty($this->search)) {
         $this->CreateSearch();
      }
      return $this;
   }

   public function CreateSearch()
   {
      $this->ResetSearch();
      $this->search = new Search(static::TABLE);
      return $this;
   }

   public function ToPrfxNm($name)
   {
      return SQL::ToPrfxNm(static::TABLE, $name);
   }

   public function ToTblNm($name)
   {
      return SQL::ToTblNm(static::TABLE, $name);
   }

   public function GetTable()
   {
      return static::TABLE;
   }

   public function GetQuery($specific, $table, $where = null, $join = null, $order = null, $limit = false)
   {
      $group = !empty($this->groupField) ? $this->groupField : null;
      return   "SELECT $specific "
             . ' FROM '
             . $table
             . (!empty($join)  ? " $join "           : '')
             . (!empty($where) ? " WHERE $where "    : '')
             . (!empty($group) ? " GROUP BY $group"  : '')
             . (!empty($order) ? " ORDER BY $order " : '')
             . ($limit         ? " LIMIT ?, ?"       : '');
   }

   public function _Select($specific, $where = null, $params = Array(), $join = null, $limit = false)
   {
      try {
         global $db;
         $result =
            $db->Query(
               $this->GetQuery(
                  $specific,
                  static::TABLE,
                  $where,
                  $join,
                  $this->order->GetOrder(),
                  $limit
               ),
               $params
            );
      } catch (Exception $e) {
         $result = Array();
      }
      return $result;
   }

   public function SelectAmount($where = null, $params = Array(), $join = null, $limit = false)
   {
      $cnt = $this->ToPrfxNm('count');
      $result =
         $this->_Select(
                  'COUNT(' . $this->ToTblNm(static::ID_FLD) . ") as $cnt",
                  $where,
                  $params,
                  $join,
                  $limit
               );
      return isset($result[0]) ? $result[0][$cnt] : 0;
   }

   public function MakeComplexJoin($join)
   {
      return 'INNER JOIN ' . $join;
   }

   public function SetSelectValues()
   {
      if ($this->samplingScheme == static::USUAL_SCHEME) {
         $this->selectFields = SQL::GetListFieldsForSelect(SQL::PrepareFieldsForSelect(static::TABLE, $this->fields));
      }
   }

   public function GetAll()
   {
      $this->CheckSearch();
      $this->SetSelectValues();
      $result =
         $this->_Select(
            $this->selectFields,
            $this->search->GetClause(),
            $this->search->GetParams(),
            $this->search->GetJoins(),
            $this->search->GetLimit()
         );
      $this->ModifySample($result);
      return $result;
   }

   public function GetPart()
   {
      $result = $this->GetAll();
      if (count($result) == 1 || $this->search->GetLimitAmount() == 1) {
         $result = $result[0];
      }
      return $result;
   }

   public function GetById($id)
   {
      $this->CheckSearch();
      $this->search->AddClause(CCond(CF(static::TABLE, $this->GetFieldByName(static::ID_FLD)), CVP($id), 'AND'));
      $result = $this->GetAll();
      $this->search->RemoveClause();
      return !empty($result[0]) ? $result[0] : [];
   }

   public function SetChangeParams()
   {
      $names  = Array();
      $params = Array();
      $GetArr = function($arr) {
         return is_array($arr) ? $arr : Array($arr);
      };
      foreach ($this->fields as $field) {
         if ($field->canChange && $field->IsSetField()) {
            try {
               $field->Validate();
               $names  = array_merge($names,  $GetArr($field->GetName()));
               $params = array_merge($params, $GetArr($field->GetValue()));
            } catch (ValidateException $e) {
               throw new ValidateException($e->getMessage());
               $last_v = static::LAST_VIEWED_ID;
               if (!empty($last_v)) {
                  $this->SetLastViewedID($this->GetFieldByName(static::ID_FLD)->GetName());
               }
            }
         }
      }
      return Array($names, $params);
   }

   public function Insert($getLastInsertId = false)
   {
      global $db;
      list($names, $params) = $this->SetChangeParams();
      $query = SQL::GetInsertQuery(static::TABLE, $names);
      $last_v = static::LAST_VIEWED_ID;
      if ($getLastInsertId || !empty($last_v)) {
         $resID = $db->Insert($query, $params, true);
         if (!empty($last_v)) {
            $this->SetLastViewedID($resID);
         }
         return $resID;
      } else {
         $db->Insert($query, $params);
      }
   }

   public function Delete($id)
   {
     global $db;
     $db->Query('DELETE FROM ' . static::TABLE . ' WHERE id = ?', Array($id));
   }

   public function Update()
   {
      global $db;
      list($names, $params) = $this->SetChangeParams();
      $query    = SQL::GetUpdateQuery(static::TABLE, $names);
      $params[] = $this->GetFieldByName('id')->GetValue();
      return $db->Query($query, $params);
   }

   public function GetFieldsValue()
   {
      $result = Array();
      foreach ($this->fields as $field) {
         $value = $field->GetValue();
         $result[$this->ToPrfxNm($field->name)] = $value;
      }
      return $result;
   }

   public function GetAllAmount()
   {
      $this->CheckSearch();
      return
         self::SelectAmount(
            $this->search->GetClause(),
            $this->search->GetParams(),
            $this->search->GetJoins(),
            $this->search->GetLimit()
         );
   }
}
