<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Entity.php';

if(!isset($_SESSION)) {
   @session_start();
}

$ajaxResult = Array('result' => true, 'message' => 'Операция прошла успешно!');

class Handler
{
   public $entity;

   public function __construct($entity)
   {
      $this->entity = $entity;
   }

   public function Update($params)
   {
      try {
         $this->entity->SetFields($params);
         $this->entity->Update();
      } catch (DBException $e) {
         throw new Exception('Возникли проблемы при обновлении записи.');
      }
   }

   public function Insert($params, $getLastInsertId = true)
   {
      try {
         $this->entity->SetFields($params);
         return $getLastInsertId ? $this->entity->Insert(true) : $this->entity->Insert(false);
      } catch (DBException $e) {
         throw new Exception('Возникли проблемы при добавлении записи.');
      }
   }

   public function Delete($params)
   {
      try {
         $this->entity->Delete($params['id']);
      } catch (DBException $e) {
         throw new Exception("Возникли проблемы при удалении записи.");
      }
   }

   public function Handle($in)
   {
      try {
         return $this->$in['mode'](isset($in['params']) ? $in['params'] : Array());
      } catch (ValidateException $e) {
         throw new Exception($e->getMessage());
      }
   }
}

function HandleAdminData($obj, $post, $url = null)
{
   $handler = new Handler($obj);
   try {
      $handler->Handle($post);
      if (!empty($url)) {
         header("Location: /admin/$url");
         exit;
      }
   } catch (Exception $e) {
      global $smarty;
      $smarty->assign('error_txt', $e->getMessage());
   }
}