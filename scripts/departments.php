<?php
if (empty($request_parts[1])) Redirect('/#departments');
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.News.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Department.php';

$data = $_department->GetByURL($request_parts[1]);
if (empty($data)) Redirect('/#departments');

$smarty->assign('department', $data)
       ->assign($_news->GetDepartmentNews($data[$_department->ToPrfxNm(Department::ID_FLD)]))
       ->display('departments.tpl');
