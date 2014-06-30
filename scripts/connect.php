<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connect_params.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Field.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/lib/exception.inc';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/constants.php';

class DBConnect
{
   public $link;
   public $isConnected = true;

   public function DBConnect($db_dsn, $db_user, $db_pass)
   {
      try {
         $this->link = new PDO($db_dsn, $db_user, $db_pass);
         $this->link->exec('SET CHARACTER SET utf8');
         $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      } catch (PDOException $e) {
         $this->isConnected = false;
      }
   }

   public function Exec($query, $getLastInsertId = false)
   {
      if (!$this->isConnected) return -1;
      $this->link->exec($query);
      return $getLastInsertId ? $this->link->lastInsertId() : -1;
   }

   public function Query($query, $params = Array())
   {
      if (!$this->isConnected) return Array();
     // echo "<br>";
     // echo "<br>";
     // echo $query;
     // echo "<br>";
     // print_r($params);
     // echo "<br>";
     // echo "<br>";
     // echo "<br>";
      $st = $this->link->prepare($query);
      if (empty($st) || !$st->execute($params)) {
         // echo "<br>";
         // echo "EXCEPTION";
         // echo "<br>";
         throw new DBException(ERROR_QUERY);
      }
      return $st->fetchAll(PDO::FETCH_ASSOC);
   }

   public function Insert($query, $params = Array(), $getLastInsertId = false)
   {
      if (!$this->isConnected) return -1;
      // echo "<br>";
      // echo "<br>";
      // echo "<br>";
      // echo $query;
      // echo "<br>";
      // echo "<br>";
      // print_r($params);
      $st = $this->link->prepare($query);
      if (empty($st) || !$st->execute($params)) {
         throw new DBException(ERROR_QUERY);
      }
      return $getLastInsertId ? $this->link->lastInsertId() : -1;
   }

}

$db = new DBConnect(DB_dsn, DB_user, DB_pass);
