<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Clause.php';

class SQL
{
   public static function GenCall($name)
   {
      return "CALL $name()";
   }

   public static function ToPrfxNm($table, $name)
   {
      return $table . '_' . $name;
   }

   public static function ToTblNm($table, $name)
   {
      return $table . '.' . $name;
   }

   public static function ToWhrCls($names)
   {
      $result = '';
      foreach ($names as $name) {
         $result .= "$name = ?, ";
      }

      return substr($result, 0, strrpos($result, ','));
   }

   public static function MakeJoin($mainTable, $tables)
   {
      $result = '';
      foreach ($tables as $table => $description) {
         $result .= 'INNER JOIN '
            . "$table "
            . (!empty($description[0]) ? $description[0] : '')
            . (!empty($description[1]) ? ' ON ' : '');
         for ($i = 1; $i < count($description); $i++) {
            $result .= self::ToTblNm($mainTable, $description[$i][0])
               . ' = '
               . self::ToTblNm(
                  (!empty($description[0]) ? $description[0] : $table),
                  $description[$i][1]
               )
               . ' AND ';
         }
         $pos = strrpos($result, 'AND');
         $result = !empty($pos) ? substr($result, 0, $pos) : $result;
      }

      return $result;
   }

   public static function GetListFieldsForSelect($fields)
   {
      $query = '';
      foreach ($fields as $f) {
         $query .= $f . ', ';
      }

      return substr($query, 0, strrpos($query, ', '));
   }

   public static function GetInsertQuery($table, $fields)
   {
      return
         'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') '
         . 'VALUES ('
         . (count($fields) - 1 >= 0 ? str_repeat('?, ', count($fields) - 1) . '?' : '')
         . ')';
   }

   public static function GetUpdateQuery($table, $fields, $field = 'id')
   {
      return
         'UPDATE ' . $table . ' SET ' . implode(' = ?, ', $fields) . ' = ?'
         . " WHERE  $field = ?";
   }

   public static function GetCallQuery($func_name, $param_amount = 0)
   {
      return sprintf('CALL %s(%s)', $func_name, ($param_amount > 0 ? '?' : '') . str_repeat(',?', $param_amount - ($param_amount != 0)));
   }

   public static function GetCallFuncQuery($func_name, $alias, $param_amount = 0)
   {
      return sprintf(
         'SELECT %s(%s) as %s', $func_name,
         ($param_amount > 0 ? '?' : '') . str_repeat(',?', $param_amount - ($param_amount != 0)),
         $alias
      );
   }

   public static function PrepareFieldsForSelect($table, $fields)
   {
      $result = Array();
      foreach ($fields as $f) {
         $field = self::ToTblNm($table, $f->GetName());
         $result[] = "$field  as " . self::ToPrfxNm($table, $f->GetName());
      }

      return $result;
   }

   public static function SimpleQuerySelect($fields, $table, $where = null)
   {
      $result = 'SELECT ' . $fields . ' FROM ' . $table;
      if (!empty($where)) {
         $result .= ' WHERE ' . $where->GetClause();
      }
      return $result;
   }
}
