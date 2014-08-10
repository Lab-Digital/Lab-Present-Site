<?php
// if (empty($_SERVER['HTTP_REFERER'])) Redirect();
if (empty($request->headers->get('referer'))) Redirect();

// $referer = $_SERVER['HTTP_REFERER'];

$smarty->assign('referer', $request->headers->get('referer'))
       ->assign('photo_data', $request->get('data'))
       ->display('upload_photo.tpl');
