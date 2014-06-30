<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/lib/exception.inc';

abstract class Validate
{
   const IS_BOOL             = 1;
   const IS_FLOAT            = 2;
   const IS_EMAIL            = 3;
   const IS_PHONE            = 4;
   const IS_NUMERIC          = 5;
   const IS_POSITIVE         = 6;
   const IS_NOT_EMPTY        = 7;
   const IS_POSITIVE_OR_ZERO = 8;
   const IS_NOT_EMPTY_STRING = 9;

}

abstract class FieldType
{
   public function Validate($value, $alias)
   {

   }
}

class StrFieldType extends FieldType
{
   private $length;

   public function __construct($length)
   {
      $this->length = $length;
   }

   public function Validate($value, $alias)
   {
      if (strlen($value) > $this->length) {
         throw new ValidateException("$alias слишком длинное!");
      }
   }
}


class IntFieldType extends FieldType
{
   private $digitAmount;

   public function __construct($digitAmount = null)
   {
      $this->digitAmount = $digitAmount;
   }
}

class TimestampFieldType extends FieldType
{

   public function Validate($value, $alias)
   {
   }
}

class TextFieldType extends FieldType
{
}

function StrType($length)
{
   return new StrFieldType($length);
}

function IntType($digitAmount = null)
{
   return new IntFieldType($digitAmount);
}

function TimestampType()
{
   return new TimestampFieldType();
}

function TextType()
{
   return new TextFieldType();
}

class Field
{
   private
      $type,
      $name,
      $alias,
      $value,
      $validate;

   public
      $canChange;

   public function __construct($name, $type, $canChange = true, $alias = '', $validate = Array(), $value = null)
   {
      $this->name      = $name;
      $this->type      = $type;
      $this->alias     = $alias;
      $this->value     = $value;
      $this->validate  = $validate;
      $this->canChange = $canChange;
   }

   public function IsValidated()
   {
      return !empty($this->validate);
   }

   public function Validate()
   {
      $value = $this->value;
      $alias = $this->alias;
      $this->type->Validate($value, $alias);
      $isException  = false;
      $exceptionStr = '';
      foreach ($this->validate as $validateType) {
         switch ($validateType) {
            case Validate::IS_NUMERIC:
               $isException  = !(empty($value) || (strlen($value) <= 10 && preg_match('/^-?[0-9]{1,4}$/', $value)));
               $exceptionStr = "$value не является числом!";
               break;

            case Validate::IS_POSITIVE:
               $isException  = !(empty($value) || ($value > 0));
               $exceptionStr = "$value не является положительным числом!";
               break;

            case Validate::IS_POSITIVE_OR_ZERO:
               $isException  = !(empty($value) || ($value > 0) || ($value == 0));
               $exceptionStr = "$value не является положительным числом или нулем!";
               break;

            case Validate::IS_FLOAT:
               $isException  = !(empty($value) || (strlen($value) <= 10 && preg_match('/^-?[\d]+(|\.[\d]+)$/', $value)));
               $exceptionStr = "$value не является дробным числом!";
               break;

            case Validate::IS_NOT_EMPTY_STRING:
               $isException  = $value === '';
               $exceptionStr = "$alias не может иметь пустое значение!";
               break;

            case Validate::IS_BOOL:
               $isException  = !(empty($value) || $value == '1' || $value == '0' || $value === true || $value === false);
               $exceptionStr = "";
               break;

            case Validate::IS_EMAIL:
               $isException  = !(preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $value));
               $exceptionStr = "$value не является правильным e-mail-ом!";
               break;

            case Validate::IS_NOT_EMPTY:
               $isException  = empty($value);
               $exceptionStr = "$alias не может иметь пустое значение!";
               break;

            case Validate::IS_PHONE:
               $isException  = !(preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $value));
               $exceptionStr = "$value не является корректным номером телефона!";
               break;
         }
      }
      if ($isException) {
         throw new ValidateException($exceptionStr);
      }
      return $this;
   }

   public function ResetField()
   {
      $this->value = null;
      return $this;
   }

   public function IsSetField()
   {
      return isset($this->value);
   }

   public function SetValue($value)
   {
      $this->value = $value;
      return $this;
   }

   public function GetValue()
   {
      return $this->value;
   }

   public function GetName()
   {
      return $this->name;
   }
}
