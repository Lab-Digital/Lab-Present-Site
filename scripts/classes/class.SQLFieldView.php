<?php
class SQLFieldView
{
   protected
      $arg;

   public function __construct($arg)
   {
      $this->arg = $arg;
   }

   public function GetSQL()
   {
      return '';
   }

   public function GetParam()
   {
      return $this->arg->GetParam();
   }

   public function IsParam()
   {
      return $this->arg->IsParam();
   }
}

class LikeView extends SQLFieldView
{
   public function GetSQL()
   {
      return 'LIKE (' . $this->arg->GetSQL() . ')';
   }
}

class MD5View extends SQLFieldView
{
   public function GetSQL()
   {
      return 'MD5(' . $this->arg->GetSQL() . ')';
   }
}
