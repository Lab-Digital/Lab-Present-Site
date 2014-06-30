<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/lib/encryption.inc';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/lib/exception.inc';

class Cookie
{
   const COOKIEPATH   = '/';
   const EXPIRATION   = 86400; //86400 seconds in a day
   const COOKIENAME   = '';
   const COOKIEDOMAIN = COOKIE_SITE;

   protected function _Package($value)
   {
      return Encryption::Encrypt($value);
   }

   protected function _Unpackage($cookie)
   {
      return Encryption::Decrypt($cookie);
   }

   protected function Set($value)
   {
      setcookie(static::COOKIENAME, $this->_Package($value), time() + static::EXPIRATION, static::COOKIEPATH, static::COOKIEDOMAIN);
   }

   public function Remove()
   {
      setcookie(static::COOKIENAME, '', 0, static::COOKIEPATH, static::COOKIEDOMAIN);
   }

}

class AuthCookie extends Cookie
{
   private $sid;

   const COOKIENAME = 'USERAUTH';

   function __construct($sid = null)
   {
      if (!empty($sid)) {
         $this->sid = $sid;
      } elseif (array_key_exists(static::COOKIENAME, $_COOKIE)) {
         $this->sid = $this->_Unpackage($_COOKIE[static::COOKIENAME]);
      } else {
         throw new CookieException();
      }
   }

   public function Set()
   {
      parent::Set($this->sid);
   }

   public function Validate()
   {
      global $_session;
      $user = $_session->GetBySID($this->sid);
      if (empty($user)) {
         throw new CookieException();
      }
      return $user[$_session->ToPrfxNm(Session::USER_FLD)];
   }

   public function GetSID()
   {
      return $this->sid;
   }

}

class CookieProfileView extends Cookie
{
   private
      $user_id;

   const COOKIENAME = 'USERPROFILEVIEW';
   const EXPIRATION = 86400; //86400 seconds in a 1 day
   // const EXPIRATION = 5;

   function __construct($user_id)
   {
      $this->user_id = $user_id;
      if (array_key_exists(static::COOKIENAME . $user_id, $_COOKIE)) {
         throw new CookieException();
      }
   }

   public function Set()
   {
      global $db;
      try {
         $db->Query(SQL::GetCallQuery('update_user_views', 1), [$this->user_id]);
      } catch (DBException $e) {
         throw new CookieException();
      }
      setcookie(
         static::COOKIENAME . $this->user_id,
         $this->_Package($this->user_id),
         time() + static::EXPIRATION,
         static::COOKIEPATH,
         static::COOKIEDOMAIN
      );
   }
}