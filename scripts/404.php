<?php

    $im = @imagecreatetruecolor(100, 100)
            or die("Невозможно создать поток изображения");

    function get_random_color($im, $alpha = -1, $alpha_start = 60, $alpha_end = 100) 
    {
        $rand_r = rand(0, 255);
        $rand_g = rand(0, 255);
        $rand_b = rand(0, 255);
        if ($alpha == -1) {
            $alpha = rand($alpha_start, $alpha_end);
        }
        return imagecolorallocatealpha($im, $rand_r, $rand_g, $rand_b, $alpha);
    }

    function drow_poly($im, $fill = false, $color = 0, $n_start = 3, $n_end = 8)
    {

        if (!$color) {
            $color = get_random_color($im);
        }

        $n = rand($n_start, $n_end);
        $arr = [];

        for ($i = 0; $i < $n * 2; $i++) {
            $arr[] = rand(-200, 200);
        }

        $drow_function = "imagepolygon";

        if ($fill) {
            $drow_function = "imagefilledpolygon";
        }

        $drow_function($im, $arr, $n, $color);
    }

    //заливаем фон
    imagefill($im, 0, 0, get_random_color($im, 100));

    $k_colors = [];
    $rand_a = rand(100, 100);
    $k_colors[] = imagecolorallocatealpha($im, 97, 44, 3, $rand_a);

    $rand_a = rand(100, 100);
    $k_colors[] = imagecolorallocatealpha($im, 240, 116, 0, $rand_a);
    
    $rand_a = rand(100, 100);
    $k_colors[] = imagecolorallocatealpha($im, 255, 185, 0, $rand_a);
    
    $rand_a = rand(100, 100);
    $k_colors[] = imagecolorallocatealpha($im, 255, 255, 0, $rand_a);
    
    shuffle($k_colors);

    foreach ($k_colors as $color) {
        drow_poly($im, 1, $color);
        //drow_poly($im, 1);
    }

	imagepng($im, $_SERVER['DOCUMENT_ROOT'] . '/images/bgu.png');
	imagedestroy($im);

	//////////////////////////////////////////////////

	$smarty->display('404.tpl');
?>