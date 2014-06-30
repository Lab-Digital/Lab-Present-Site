<?php
function SetActiveItem($item = 'main')
{
   global $smarty;
   $smarty->assign('active_item', $item);
}

function GetPage()
{
   return isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] - 1 : 0;
}

function Redirect($url = '/')
{
   header("Location: $url");
   exit;
}

function _GeneratePages($amount, $amount_on_page)
{
   $current_page = GetPage() + 1;
   $newsOnPage = $amount_on_page;
   $pagesAmount = $newsOnPage != 0 ? ceil($amount / $newsOnPage) : 0;
   if ($pagesAmount > 7) {
      if ($current_page <= 4) {
         $result = array_merge(range(1, $current_page + 2), array('...', $pagesAmount));
      } elseif ($current_page > 4 and $pagesAmount - $current_page > 4) {
         $result = array_merge(array(1, '...'), range($current_page - 2, $current_page + 2), array('...', $pagesAmount));
      } elseif ($pagesAmount - $current_page <= 4) {
         $result = array_merge(array(1, '...'), range($current_page - 2, $pagesAmount));
      }
   } elseif ($pagesAmount == 0) {
      $result = [1];
   } else {
      $result = range(1, $pagesAmount);
   }
   return [$current_page - 1, ['amount' => $pagesAmount, 'num' => $result]];
}

function GeneratePages($obj)
{
   return _GeneratePages($obj->GetAllAmount(), $obj::AMOUNT_PAGE);
}

function GetPOST($deleteTags = true)
{
   foreach ($_POST as &$value) {
      if (!is_array($value)) {
         $value = trim($value);
         if ($deleteTags) {
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
         }
      }
   }
   return $_POST;
}

function GetRequest() {
   return explode('/', substr($_SERVER['REQUEST_URI'], 1));
}

function CutString($str, $amount)
{
   $new_str = mb_substr($str, 0, $amount);
   if ($str != $new_str) {
      $new_str .= '...';
   }
   return $new_str;
}
