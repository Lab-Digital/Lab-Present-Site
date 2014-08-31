<?php
require_once CLASSES_ROOT  . 'class.MainSlider.php';
require_once HANDLERS_ROOT . 'handler.php';

SetLastViewedID(MainSlider::LAST_VIEWED_ID);

$vars['number'] = $vars['url'] = $vars['head'] = $vars['text'] = $vars['position'] = null;

if ($request->get('mode')) {
   $id               = $request->get('id');
   $vars['url']      = $request->get('url');
   $vars['text']     = $request->get('text');
   $vars['head']     = $request->get('head');
   $vars['number']   = $request->get('number');
   $vars['position'] = $request->get('position');
   $_mainSlider->SetLastViewedID($id);
   HandleAdminData($_mainSlider, [
      'mode' => $request->get('mode'),
      'params' => [
         MainSlider::ID_FLD       => $id,
         MainSlider::URL_FLD      => $vars['url'],
         MainSlider::TEXT_FLD     => $vars['text'],
         MainSlider::HEAD_FLD     => $vars['head'],
         MainSlider::NUMBER_FLD   => $vars['number'],
         MainSlider::POSITION_FLD => $vars['position']
      ]
   ], 'slider');
   SetLastViewedID(MainSlider::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('positions', $_mainSlider->positions)
       ->assign('isInsert', $request->get('mode') == 'Insert')
       ->assign('item_id', $request->query->get('item_id'))
       ->assign('sliders', $_mainSlider->GetAll())
       ->display('admin.slider.tpl');
