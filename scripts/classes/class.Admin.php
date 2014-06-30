<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Entity.php';

class Admin extends Entity
{
   const COURSE_SCHEME = 2;

   const PASS_FLD  = 'pass_md5';
   const LOGIN_FLD = 'login';

   const TABLE = 'admin';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::LOGIN_FLD,
            StrType(50),
            true,
            'Логин администратора',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::PASS_FLD,
            StrType(50),
            true,
            'информация о преподавателе',
            Array(Validate::IS_NOT_EMPTY)
         )
      );
   }

   private function CheckPermissions($login, $pass)
   {
      $this->CreateSearch();
      $this->search->AddClause(
         CCond(
            CF(static::TABLE, $this->GetFieldByName(static::LOGIN_FLD)),
            CVP($login)
         )
      );
      $this->search->AddClause(
         CCond(
            CF(static::TABLE, $this->GetFieldByName(static::PASS_FLD)),
            new MD5View(CVP($pass)),
            'AND'
         )
      );
      $adminInfo = $this->GetPart();
      return !empty($adminInfo);
   }

   public function IsAdmin($login = null, $pass = null)
   {
      if (!empty($login) && !empty($pass)) {
         $admin_login = $login;
         $admin_pass  = $pass;
      } elseif (!empty($_SESSION['admin_login']) && !empty($_SESSION['admin_pass'])) {
         $admin_login = $_SESSION['admin_login'];
         $admin_pass  = $_SESSION['admin_pass'];
      } else return false;
      $result = $this->CheckPermissions($admin_login, $admin_pass);
      if ($result) {
         $this->SetSessionParams($admin_login, $admin_pass);
      }
      return $result;
   }

   public function ChangeData($login, $pass, $new_pass)
   {
      global $smarty;
      if (empty($pass)) {
         $smarty->assign('error_txt', 'Необходимо ввести пароль!');
      } else if (empty($login)) {
         $smarty->assign('error_txt', 'Логин не может быть пустым!');
      } else if (!$this->CheckPermissions($_SESSION['admin_login'], $pass)) {
         $smarty->assign('error_txt', 'Неправильный пароль!');
      } else {
         $this->SetFieldByName(static::ID_FLD, ADMIN_ID);
         $this->SetFieldByName(static::LOGIN_FLD, $login);
         $session_pass = $pass;
         if (!empty($new_pass)) {
            $session_pass = $new_pass;
            $this->SetFieldByName(static::PASS_FLD, $new_pass);
         }
         try {
            parent::Update();
            $this->SetSessionParams(
               $login,
               $session_pass
            );
            header('Location: /admin/texts');
            exit;
         } catch (Exception $e) {
            $smarty->assign('error_txt', 'В данный момент невозможно обновить данные. Попробуйте позже.');
         }
      }
   }

   public function SetSelectValues()
   {
      $this->selectFields =
         SQL::GetListFieldsForSelect(
            SQL::PrepareFieldsForSelect(
               static::TABLE,
               Array(
                  $this->idField,
                  $this->GetFieldByName(static::LOGIN_FLD)
               )
            )
         );
   }

   public function GetById($id)
   {
      $this->ResetSearch();
      return parent::GetById($id);
   }

   private function SetSessionParams($login, $pass)
   {
      $_SESSION['admin_login'] = $login;
      $_SESSION['admin_pass']  = $pass;
   }

}

$_admin = new Admin();