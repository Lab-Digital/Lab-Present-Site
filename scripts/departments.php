<?php
if (empty($request_parts[1])) Redirect('/#departments');
require_once CLASSES_ROOT . 'class.News.php';

$data = $_department->SetSamplingScheme(Department::USUAL_SCHEME)->GetByURL($request_parts[1]);
if (empty($data)) Redirect('/#departments');

$smarty->assign('department', $data)
       ->assign($_news->GetDepartmentNews($data[$_department->ToPrfxNm(Department::ID_FLD)]))
       ->display('departments.tpl');
