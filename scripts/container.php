<?php
if(!isset($_SESSION)) {
   @session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/settings.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/utils.php';

$request = GetRequest();
