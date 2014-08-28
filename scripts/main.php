<?php
require_once CLASSES_ROOT . 'class.Meta.php';
require_once CLASSES_ROOT . 'class.Project.php';
require_once CLASSES_ROOT . 'class.MainSlider.php';

$smarty->assign('meta', $_meta->SetSamplingScheme(Meta::PAGE_SCHEME)->GetById(Meta::INDEX_META_ID))
       ->assign('sliders', $_mainSlider->SetSamplingScheme(MainSlider::PAGE_SCHEME)->GetAll())
       ->assign('projects', $_project->SetSamplingScheme(Project::MAIN_SCHEME)->GetAll())
       ->display('index.tpl');
