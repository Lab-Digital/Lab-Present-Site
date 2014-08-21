<?php
if (empty($request_parts[1])) Redirect('/#departments');
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Department.php';

$data = $_department->GetByURL($request_parts[1]);
if (empty($data)) Redirect('/#departments');

$smarty->assign('department', $data)->display('departments.tpl');
