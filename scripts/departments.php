<?php
if (empty($request_parts[1])) Redirect('/#departments');
require_once CLASSES_ROOT . 'class.News.php';

$data = $_department->SetSamplingScheme(Department::USUAL_SCHEME)->GetByURL($request_parts[1]);
if (empty($data)) Redirect('/#departments');

$im = imagecreatetruecolor(604, 300) 
	  or die("Невозможно создать поток изображения");

//$black = imagecolorallocate($im, 0, 0, 0);
//imagecolortransparent($im, $black);

imagealphablending($im, false);
$transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $transparent);
imagesavealpha($im, true);
imagealphablending($im, true);
$color = imagecolorallocatealpha($im, 0, 0, 0, 121);

imagettftext($im, 150, 0, 0, 180, $color, $_SERVER['DOCUMENT_ROOT'] . "/images/arialbd.ttf", $data['departments_head']);
imagepng($im, $_SERVER['DOCUMENT_ROOT'] . "/images/dephead" . $data['departments_id'] . ".png");
imagedestroy($im);
$smarty->assign('department', $data)
       ->assign('articles', $_news->SetSamplingScheme(News::DEPARTMENT_SCHEME)->GetAll())
       ->display('departments.tpl');
