<?php
if(!isset($_SESSION)) {
   @session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
$request = Request::createFromGlobals();

require_once SCRIPTS_ROOT . 'constants.php';
require_once SCRIPTS_ROOT . 'settings.php';
require_once SCRIPTS_ROOT . 'utils.php';

$request_parts = GetRequestParts($request);

$ds = ['', 'departments', 'news', 'resume', 'contacts'];

foreach ($ds as $d) {
   if ($d == $request_parts[0]) {
      require_once CLASSES_ROOT . 'class.Department.php';
      $smarty->assign('departments', $_department->SetSamplingScheme(Department::MAIN_SCHEME)->GetAll());
      break;
   }
}
