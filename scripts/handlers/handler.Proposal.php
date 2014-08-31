<?php
require_once SCRIPTS_ROOT  . 'utils.php';
require_once CLASSES_ROOT  . 'class.Proposal.php';
require_once HANDLERS_ROOT . 'handler.php';

$ajaxResult['error_field'] = null;

class ProposalHandler extends Handler
{
   public function __construct()
   {
      $this->entity = new Proposal();
   }

   public function Handle($in)
   {
      error_log("in <= " . json_encode($in));
      $params = [
         'name'          => $in['name'],
         'phone'         => $in['phone'],
         'email'         => $in['email'],
      ];
      $params['department_id'] = !empty($in['category']) ? $in['category'] : null;
      $params['task'] = !empty($in['text']) ? $in['text'] : null;
      try {
         return $this->Insert($params);
      } catch (ValidateException $e) {
         throw new Exception($e->getMessage());
      }
   }

   private function Validate($field, $func, $param)
   {
      global $ajaxResult;
      try {
         $this->entity->$func($param);
      } catch (Exception $e) {
         $ajaxResult['error_field'] = $field;
         throw new Exception($e->getMessage());
      }
      return $this;
   }

   public function Insert($params, $getLastInsertId = true)
   {
      global $ajaxResult;
      $this->Validate('name',  'ValidateName',  !empty($params['name'])  ? $params['name']  : null)
           ->Validate('phone', 'ValidatePhone', !empty($params['phone']) ? $params['phone'] : null)
           ->Validate('email', 'ValidateEmail', !empty($params['email']) ? $params['email'] : null);
      if (count($_FILES) > 0) {
         if (!file_exists(UPLOAD_ZIP_DIR)) {
            mkdir(UPLOAD_ZIP_DIR);
         }
         if (!file_exists(UPLOAD_ZIP_DIR . 'tmp/')) {
            mkdir(UPLOAD_ZIP_DIR . 'tmp/');
         }
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
      }
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
