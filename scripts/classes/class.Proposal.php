<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Mail.php';

class Proposal extends Entity
{
   const ABOUT_TEXT_ID = 1;

   const ZIP_FLD        = 'zip_name';
   const DATE_FLD       = 'date';
   const NAME_FLD       = 'name';
   const TASK_FLD       = 'task';
   const EMAIL_FLD      = 'email';
   const PHONE_FLD      = 'phone';
   const EXPRESS_FLD    = 'is_express';
   const DEPARTMENT_FLD = 'department_id';

   const TABLE = 'proposal';

   const AMOUNT_ON_PAGE = 20;

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::NAME_FLD,
            StrType(180, 'Имя слишком длинное!'),
            true,
            'Имя',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::DATE_FLD,
            TimestampType(),
            false
         ),
         new Field(
            static::EMAIL_FLD,
            StrType(180),
            true,
            'E-mail',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::PHONE_FLD,
            StrType(30),
            true,
            'Телефон',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::TASK_FLD,
            TextType(),
            true
         ),
         new Field(
            static::DEPARTMENT_FLD,
            IntType(),
            true,
            'Отдел',
            Array(Validate::IS_NOT_EMPTY)
         ),
         new Field(
            static::EXPRESS_FLD,
            IntType(),
            true
         ),
         new Field(
            static::ZIP_FLD,
            TextType(),
            true,
            'Прикрепления'
         )
      );
      $this->orderFields =
         [static::DATE_FLD => new OrderField(static::TABLE, $this->GetFieldByName(static::DATE_FLD))];
   }

   public function Insert($getLastInsertId = false)
   {
      global $db;
      list($names, $params) = $this->SetChangeParams();
      $query = SQL::GetInsertQuery(static::TABLE, $names);
      (new Mail())->SendNewProposalMail(
         $this->GetFieldByName(static::NAME_FLD)->GetValue(),
         $this->GetFieldByName(static::EMAIL_FLD)->GetValue(),
         $this->GetFieldByName(static::PHONE_FLD)->GetValue(),
         $this->GetFieldByName(static::TASK_FLD)->GetValue()
      );
      $db->Insert($query, $params);
   }

   public function SetSelectValues()
   {
      $this->AddOrder(static::DATE_FLD, OT_DESC);
      parent::SetSelectValues();
   }

   public function ModifySample(&$sample)
   {
      if (empty($sample)) return;
      $dateKey = $this->ToPrfxNm(static::DATE_FLD);
      foreach ($sample as &$set) {
         $date_var = new DateTime($set[$dateKey]);
         $set[$dateKey] = $date_var->format('d.m.Y H:m');
      }
   }

   public function GetProposals()
   {
      list($pageNum, $pagesInfo) = _GeneratePages($this->GetAllAmount(), static::AMOUNT_ON_PAGE);
      return [
         'curPage'   => $pageNum + 1,
         'pagesInfo' => $pagesInfo,
         'proposals' => $this->AddLimit(static::AMOUNT_ON_PAGE, $pageNum * static::AMOUNT_ON_PAGE)->GetAll()
      ];
   }

   public function ValidatePhone($phone)
   {
      if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $phone)) {
         throw new Exception(ERROR_CONTACT_PHONE);
      }
      return $this;
   }

   public function ValidateEmail($email)
   {
      if (!preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $email)) {
         throw new Exception(INCORRECT_MAIL);
      }
      return $this;
   }

   public function ValidateDepartment($department)
   {
      if (empty($department) || !is_numeric($department)) {
         throw new Exception(INCORRECT_DEPARTMENT);
      }
      return $this;
   }
}

$_proposal = new Proposal();
