<?php
require_once SCRIPTS_ROOT  . 'utils.php';
require_once CLASSES_ROOT  . 'class.Proposal.php';
require_once HANDLERS_ROOT . 'handler.php';

class ProposalHandler extends Handler
{
   public function __construct()
   {
      $this->entity = new Proposal();
   }

   public function Insert($params, $getLastInsertId = true)
   {
      $this->entity->ValidatePhone(!empty($params['phone']) ? $params['phone'] : null)
                   ->ValidateEmail(!empty($params['email']) ? $params['email'] : null)
                   ->ValidateDepartment(!empty($params['department_id']) ? $params['department_id'] : null);
      try {
         $this->entity->SetFields($params);
         return $getLastInsertId ? $this->entity->Insert(true) : $this->entity->Insert(false);
      } catch (DBException $e) {
         throw new Exception('Возникли проблемы при добавлении заявки.');
      }
   }
}

try {
   $handler = (new ProposalHandler())->Handle($request->request->all());
} catch (Exception $e) {
   $ajaxResult['result'] = false;
   $ajaxResult['message'] = $e->getMessage();
}

echo json_encode($ajaxResult);
