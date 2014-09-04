<?php
function SetActiveItem($item = 'main')
{
   global $smarty;
   $smarty->assign('active_item', $item);
}

function DateToMySqlDate($date_str)
{
   $date_var = new DateTime($date_str);
   return !empty($date_str) ? $date_var->format('Y-m-d H:i:s') : '';
}

function GetPage()
{
   global $request;
   return $request->query->getInt('page', 1) - 1;
}

function Redirect($url = '/')
{
   header("Location: $url");
   exit;
}

function _GeneratePages($amount, $amount_on_page)
{
   $current_page = GetPage() + 1;
   $pagesAmount = $amount_on_page != 0 ? ceil($amount / $amount_on_page) : 0;
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

function ValidatePOST($deleteTags = true)
{
   global $request;
   foreach ($request->request->all() as $key => $value) {
      if (!is_array($value)) {
         $value = trim($value);
         if ($deleteTags) {
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
         }
         $request->request->set($key, $value);
      }
   }
}

function SetLastViewedID($name)
{
   global $smarty;
   if (isset($_SESSION[$name])) {
      $smarty->assign('last_viewed_id', $_SESSION[$name]);
      unset($_SESSION[$name]);
   }
}

function IsPositiveNumber($number)
{
   return filter_var($number, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
}

function GetRequestParts($request)
{
   return explode('/', substr($request->getPathInfo(), 1));
}

function CutString($str, $amount)
{
   $new_str = mb_substr($str, 0, $amount);
   if ($str != $new_str) {
      $new_str .= '...';
   }
   return $new_str;
}
