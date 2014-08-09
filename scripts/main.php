<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Texts.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Slider.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Service.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.IndexMeta.php';

$smarty->assign('meta', $_indexMeta->GetById(IndexMeta::META_ID))
       // ->assign('sliders',  $_slider->GetAll())
       // ->assign('services', $_service->SetSamplingScheme(Service::MAIN_SCHEME)->GetAll())
       // ->assign('projects', $_texts->SetSamplingScheme(Texts::MAIN_PROJECTS_SCHEME)->GetAll())
       // ->assign('about',    $_texts->SetSamplingScheme(Texts::ABOUT_SCHEME)->GetById(Texts::ABOUT_TEXT_ID))
       // ->assign('isMain',   true)
       ->display('index.tpl');
