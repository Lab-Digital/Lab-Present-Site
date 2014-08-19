<?php
// require_once CLASSES_ROOT . 'class.Texts.php';
// require_once CLASSES_ROOT . 'class.Slider.php';
require_once CLASSES_ROOT . 'class.Department.php';
require_once CLASSES_ROOT . 'class.IndexMeta.php';

$smarty->assign('meta', $_indexMeta->GetById(IndexMeta::META_ID))
       ->assign('departments', $_department->SetSamplingScheme(Department::MAIN_SCHEME)->GetAll())
       // ->assign('sliders',  $_slider->GetAll())
       // ->assign('services', $_service->SetSamplingScheme(Service::MAIN_SCHEME)->GetAll())
       // ->assign('projects', $_texts->SetSamplingScheme(Texts::MAIN_PROJECTS_SCHEME)->GetAll())
       // ->assign('about',    $_texts->SetSamplingScheme(Texts::ABOUT_SCHEME)->GetById(Texts::ABOUT_TEXT_ID))
       // ->assign('isMain',   true)
       ->display('index.tpl');
