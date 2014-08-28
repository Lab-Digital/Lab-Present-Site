<?php
// require_once CLASSES_ROOT . 'class.Texts.php';
// require_once CLASSES_ROOT . 'class.Slider.php';
require_once CLASSES_ROOT . 'class.Meta.php';
require_once CLASSES_ROOT . 'class.Project.php';

$smarty->assign('meta', $_meta->SetSamplingScheme(Meta::PAGE_SCHEME)->GetById(Meta::INDEX_META_ID))
       ->assign('projects', $_project->SetSamplingScheme(Project::MAIN_SCHEME)->GetAll())
       // ->assign('sliders',  $_slider->GetAll())
       // ->assign('services', $_service->SetSamplingScheme(Service::MAIN_SCHEME)->GetAll())
       // ->assign('projects', $_texts->SetSamplingScheme(Texts::MAIN_PROJECTS_SCHEME)->GetAll())
       // ->assign('about',    $_texts->SetSamplingScheme(Texts::ABOUT_SCHEME)->GetById(Texts::ABOUT_TEXT_ID))
       // ->assign('isMain',   true)
       ->display('index.tpl');
