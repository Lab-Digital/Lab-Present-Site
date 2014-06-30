<?php
function crop_and_resize ($im, $x1, $y1, $x2, $y2, $new_width, $new_height) {
   $im_w = abs($x1 - $x2);
   $im_h = abs($y1 - $y2);
   $new_img = imagecreatetruecolor($new_width, $new_height);
   imagecopyresampled($new_img, $im, 0, 0, $x1, $y1, $new_width, $new_height, $im_w, $im_h);
   return $new_img;
}

$uploaddir    = 'uploads/';
$image_name   = $_POST['fileName'];
$path         = $uploaddir . $image_name . '.jpg';
$im           = imagecreatefromjpeg($path);
$arr          = getimagesize($path);
$owner_width  = $arr[0];
$owner_height = $arr[1];
$width        = $_POST['width'];
$height       = $_POST['height'];
$after_resize = $_POST['afterResize'];

$crop_type = $_POST['cropType'];

if ($crop_type == 'userCrop') {
   $x1 = $_POST['x1'];
   $y1 = $_POST['y1'];
   $x2 = $_POST['x2'];
   $y2 = $_POST['y2'];
} else {
   $x1 = floor(($owner_width - $width) / 2);
   $y1 = floor(($owner_height - $height) / 2);
   $x2 = $x1 + $width;
   $y2 = $y1 + $height;
}

$p_sizes   = explode(',', $_POST['sizes']);

foreach ($p_sizes as $size) {
   $sizes = explode('#', $size);
   $n_name = $sizes[0];
   $n_width = $sizes[1];
   $n_height = $sizes[2];
   $new_img = crop_and_resize($im, $x1, $y1, $x2, $y2, $n_width, $n_height);
   imagejpeg($new_img, $uploaddir . $image_name . '_' . $n_name . '.jpg');
}

if (isset($after_resize) && $after_resize > 0) {
   if ($owner_width <= $after_resize && $owner_height <= $after_resize) {
      $h = $owner_height;
      $w = $owner_width;
   } else if ($owner_width >= $owner_height) {
      //ширина
      $h = round($after_resize / $owner_width * $owner_height);
      $w = $after_resize;
   } else {
      $w = round($after_resize / $owner_height * $owner_width);
      $h = $after_resize;
   }
   $big = imagecreatetruecolor($w, $h);
   imagecopyresampled($big, $im, 0, 0, 0, 0, $w, $h, $owner_width, $owner_height);
   imagejpeg($big, $uploaddir . $image_name . '_b.jpg');
}


require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Image.php';

$_image->SetFieldByName(Image::ID_FLD, $image_name)->SetFieldByName(Image::IS_RESIZED_FLD, 1)->Update();
