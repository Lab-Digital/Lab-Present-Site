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
      $upload_dir = 'uploads/';
      $idx = 0;
      $file_names = [];
      $seed = new DateTime();
      $seed = $seed->getTimestamp();
      $s_zip_name = md5($seed . $idx);
      $f_zip_name = $upload_dir . $s_zip_name;
      $zip = new ZipArchive();
      if ($zip->open($f_zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
         throw new Exception("Невозможно открыть <$zip_name>\n");
      }
      foreach ($_FILES as $file) {
         $idx++;
         //uploads/tmp - temp directory for users files
         //zip archive stored in uploads
         //uploads/tmp directory clears as soon as possible
         $new_name = $upload_dir. "tmp/" . $file["name"];
         // error_log($new_name);
         move_uploaded_file($file["tmp_name"], $new_name);
         $zip->addFile($new_name);
         array_push($file_names, $new_name);
      }
      $zip->close();
      //clear uploads/tmp directory
      foreach($file_names as $file_name) {
         unlink($file_name);
      }
      $params[Proposal::ZIP_FLD] = $s_zip_name;
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
