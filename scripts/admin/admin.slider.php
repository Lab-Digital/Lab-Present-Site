<?php
require_once CLASSES_ROOT  . 'class.MainSlider.php';
require_once HANDLERS_ROOT . 'handler.php';

SetLastViewedID(MainSlider::LAST_VIEWED_ID);

$vars['number'] = $vars['url'] = $vars['head'] = $vars['text'] = $vars['color'] = $vars['text_color'] = null;

if ($request->get('mode')) {
   $id                 = $request->get('id');
   $vars['url']        = $request->get('url');
   $vars['text']       = $request->get('text');
   $vars['head']       = $request->get('head');
   $vars['color']      = $request->get('color');
   $vars['number']     = $request->get('number');
   $vars['text_color'] = $request->get('text_color');
   $_mainSlider->SetLastViewedID($id);
   HandleAdminData($_mainSlider, [
      'mode' => $request->get('mode'),
      'params' => [
         MainSlider::ID_FLD         => $id,
         MainSlider::URL_FLD        => $vars['url'],
         MainSlider::TEXT_FLD       => $vars['text'],
         MainSlider::HEAD_FLD       => $vars['head'],
         MainSlider::COLOR_FLD      => $vars['color'],
         MainSlider::NUMBER_FLD     => $vars['number'],
         MainSlider::TEXT_COLOR_FLD => $vars['text_color']
      ]
   ], 'slider');
   SetLastViewedID(MainSlider::LAST_VIEWED_ID);
}

$smarty->assign($vars)
       ->assign('isInsert', $request->get('mode') == 'Insert')
       ->assign('item_id', $request->query->get('item_id'))
       ->assign('sliders', $_mainSlider->GetAll())
       ->display('admin.slider.tpl');
