<?php
require_once CLASSES_ROOT . 'class.Portfolio.php';
$smarty->assign('portfolio', $_portfolio->SetSamplingScheme(Portfolio::GRID_SCHEME)->GetAll())->display('portfolio.tpl');
