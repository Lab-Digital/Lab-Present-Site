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

$ds = ['', 'departments', 'projects', 'news', 'resume', 'contacts'];

foreach ($ds as $d) {
   if ($d == $request_parts[0]) {
      require_once CLASSES_ROOT . 'class.Settings.php';
      require_once CLASSES_ROOT . 'class.Department.php';
      $smarty->assign('departments', $_department->SetSamplingScheme(Department::MAIN_SCHEME)->GetAll());
      $flag = $_settings->SetSamplingScheme(Settings::PAGE_SCHEME)->GetById(Settings::SOCIAL_ID)[$_settings->ToPrfxNm(Settings::FLAG_FLD)];
      $socials = [];
      if ($flag) {
         require_once CLASSES_ROOT . 'class.Socials.php';
         $socials = $_socials->SetSamplingScheme(Socials::PAGE_SCHEME)->GetAll();
      }
      $smarty->assign('socials', $socials);
      break;
   }
}
