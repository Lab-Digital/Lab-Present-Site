<?php
require_once CLASSES_ROOT . 'class.Entity.php';

class Image extends Entity
{
   const EXT_FLD        = 'ext';
   const IS_RESIZED_FLD = 'is_resized';

   const TABLE = 'images';

   public function __construct()
   {
      parent::__construct();
      $this->fields = Array(
         $this->idField,
         new Field(
            static::IS_RESIZED_FLD,
            IntType(),
            true
         ),
         new Field(
            static::EXT_FLD,
            StrType(5),
            true
         ),
      );
   }

   public function DeleteImg($id, $ext)
   {
      $r = ['', '_b', '_s', '_m'];
      foreach ($r as $v) {
         @unlink(sprintf('%s/images/uploads/%s%s.%s', $_SERVER['DOCUMENT_ROOT'], $id, $v, $ext));
      }
   }

   public function Delete($id)
   {
      parent::Delete($id);
      $this->DeleteImg($id, $this->GetFieldByName(static::EXT_FLD)->GetValue());
      global $db;
      try {
         $db->link->beginTransaction();
         $query = SQL::SimpleQuerySelect(
            sprintf('%s, %s', $this->ToTblNm(static::ID_FLD), $this->ToTblNm(static::EXT_FLD)),
            static::TABLE,
            new Clause(
               CCond(
                  CF(static::TABLE, $this->GetFieldByName(static::IS_RESIZED_FLD)),
                  CVS(0)
               )
            )
         );
         $sample = $db->Query($query);
         $db->Query('DELETE FROM ' . static::TABLE . ' WHERE ' . static::IS_RESIZED_FLD . ' = 0');
         foreach ($sample as &$set) {
            $this->DeleteImg($set[static::ID_FLD], substr($set[static::EXT_FLD], strpos($set[static::EXT_FLD], '.') + 1));
         }
         $db->link->commit();
      } catch (DBException $e) {
         $db->link->rollback();
         throw new Exception($e->getMessage());
      }
   }

}

$_image = new Image();

function SetCondForResizedImages(&$search, $photo_fld)
{
   global $_image;
   $search->SetJoins([Image::TABLE => [null, [$photo_fld, Image::ID_FLD]]]);
   $search->AddClause(
      CCond(
         CF(Image::TABLE, $_image->GetFieldByName(Image::IS_RESIZED_FLD)),
         CVP(1),
         'AND'
      )
   );
}

function ImageSelectSQL($th, $entity, $field)
{
   global $_image;
   return sprintf(
      "IFNULL((SELECT GROUP_CONCAT(%s) FROM %s %s WHERE %s GROUP BY %s), '') as %s",
      $entity->ToTblNm($entity::PHOTO_FLD),
      $entity::TABLE,
      SQL::MakeJoin($entity::TABLE, [Image::TABLE => [null, [$entity::PHOTO_FLD, Image::ID_FLD]]]),
      (new Clause(
         CCond(
            CF($entity::TABLE, $entity->GetFieldByName($field)),
            CF($th::TABLE, $th->GetFieldByName($th::ID_FLD))
         ),
         CCond(
            CF(Image::TABLE, $_image->GetFieldByName(Image::IS_RESIZED_FLD)),
            CVS(1),
            'AND'
         )
      ))->GetClause(),
      $th->ToTblNm($th::ID_FLD),
      $th->ToPrfxNm($th::PHOTOS_FLD)
   );
}

function ImageWithFlagSelectSQL($table, $field, $withFlag = true)
{
   global $_image;
   $clause = new Clause(CCond(
         CF($table, $field),
         CF(Image::TABLE, $_image->GetFieldByName(Image::ID_FLD))
   ));
   if ($withFlag) {
      $clause->AddClause(CCond(
         CF(Image::TABLE, $_image->GetFieldByName(Image::IS_RESIZED_FLD)),
         CVS(1),
         cAND
      ));
   }
   return sprintf(
      "IFNULL((%s), '') as %s",
      SQL::SimpleQuerySelect(
         sprintf('CONCAT(%s, %s)', $_image->ToTblNm(Image::ID_FLD), $_image->ToTblNm(Image::EXT_FLD)),
         Image::TABLE,
         $clause
      ),
      SQL::ToPrfxNm($table, $field->GetName())
   );
}

function ModifySampleWithImage(&$sample, $image_fields)
{
   foreach ($sample as &$set) {
      foreach ($image_fields as $field_name) {
         $tmp = !empty($set[$field_name]) ? explode('.', $set[$field_name]) : [];
         $set[$field_name] = !empty($tmp) ? ['name' => $tmp[0], 'ext' => $tmp[1]] : null;
      }
   }
}
