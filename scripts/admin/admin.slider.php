<?php
require_once CLASSES_ROOT  . 'class.MainSlider.php';
require_once HANDLERS_ROOT . 'handler.php';

SetLastViewedID(MainSlider::LAST_VIEWED_ID);

$vars['number'] = $vars['url'] = null;

if ($request->get('mode')) {
   $id             = $request->get('id');
   $vars['url']    = $request->get('url');
   $vars['number'] = $request->get('number');
   $_mainSlider->SetLastViewedID($id);
   HandleAdminData($_mainSlider, [
      'mode' => $request->get('mode'),
      'params' => [
         MainSlider::ID_FLD     => $id,
         MainSlider::URL_FLD    => $vars['url'],
         MainSlider::NUMBER_FLD => $vars['number']
      ]
   ], 'slider');
   SetLastViewedID(MainSlider::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('isInsert', $request->get('mode') == 'Insert')
       ->assign('item_id', $request->query->get('item_id'))
       ->assign('sliders', $_mainSlider->GetAll())
       ->display('admin.slider.tpl');
