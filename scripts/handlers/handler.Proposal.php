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

   public function Handle($in)
   {
      $params = [
         'name'          => $in['name'],
         'phone'         => $in['phone'],
         'email'         => $in['email'],
         'department_id' => $in['category'],
         'task'          => $in['text']
      ];
      try {
         return $this->$in['mode']($params);
      } catch (ValidateException $e) {
         throw new Exception($e->getMessage());
      }
   }

   public function Insert($params, $getLastInsertId = true)
   {
      if (!file_exists(UPLOAD_ZIP_DIR)) {
         mkdir(UPLOAD_ZIP_DIR);
      }
      if (!file_exists(UPLOAD_ZIP_DIR . 'tmp/')) {
         mkdir(UPLOAD_ZIP_DIR . 'tmp/');
      }
      $this->entity->ValidatePhone(!empty($params['phone']) ? $params['phone'] : null)
                   ->ValidateEmail(!empty($params['email']) ? $params['email'] : null)
                   ->ValidateDepartment(!empty($params['department_id']) ? $params['department_id'] : null);
      $idx = 0;
      $file_names = [];
      $seed = new DateTime();
      $seed = $seed->getTimestamp();
      $s_zip_name = md5($seed . $idx);
      $f_zip_name = UPLOAD_ZIP_DIR . $s_zip_name . '.zip';
      $zip = new ZipArchive();
      if ($zip->open($f_zip_name, ZipArchive::CREATE) !== TRUE) {
         throw new Exception('Возникли проблемы при загрузке файлов.');
      }
      foreach ($_FILES as $file) {
         $idx++;
         $new_name = UPLOAD_ZIP_DIR . 'tmp/' . $file['name'];
         move_uploaded_file($file['tmp_name'], $new_name);
         $zip->addFile($new_name, $file['name']);
         array_push($file_names, $new_name);
      }
      $zip->close();
      foreach($file_names as $file_name) {
         @unlink($file_name);
      }
      $params[Proposal::ZIP_FLD] = $s_zip_name;
      try {
         // $params[Proposal::FILE_FLD] = $zip_name;
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
