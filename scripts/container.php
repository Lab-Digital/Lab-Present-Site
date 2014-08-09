<?php
if(!isset($_SESSION)) {
   @session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
$request = Request::createFromGlobals();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/settings.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/utils.php';

$request_parts = GetRequestParts($request);
