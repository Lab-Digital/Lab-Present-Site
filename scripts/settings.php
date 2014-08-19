<?php
define('SMARTY_DIR', SCRIPTS_ROOT . 'smarty/libs/');
require_once SMARTY_DIR . 'Smarty.class.php';

class TSmarty extends Smarty
{

   function __construct()
   {
      $dir = $_SERVER['DOCUMENT_ROOT'] . '/';

      parent::__construct();

      $this->setTemplateDir($dir . 'templates/');
      $this->setCompileDir($dir . 'templates_c/');
      $this->setConfigDir($dir . 'configs/');
      $this->setCacheDir($dir . 'cache/');

      // $this->caching = Smarty::CACHING_LIFETIME_CURRENT;
      $this->assign('app_name', SMARTY_APP_NAME);
   }
}

$smarty = new TSmarty();
$smarty->force_compile = true;
