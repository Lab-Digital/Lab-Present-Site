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
