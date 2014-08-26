<?php

$referer = $request->headers->get('referer');

if (empty($referer)) {
	Redirect();
}

$smarty->assign('referer', $referer)
       ->assign('photo_data', $request->get('data'))
       ->display('upload_photo.tpl');
