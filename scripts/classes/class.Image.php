<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/classes/class.Entity.php';

class Image extends Entity
{
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
         )
      );
   }

   public function DeleteImg($id)
   {
      @unlink($_SERVER['DOCUMENT_ROOT'] . '/scripts/uploads/' . $id . '.jpg');
      @unlink($_SERVER['DOCUMENT_ROOT'] . '/scripts/uploads/' . $id . '_b.jpg');
      @unlink($_SERVER['DOCUMENT_ROOT'] . '/scripts/uploads/' . $id . '_s.jpg');
      @unlink($_SERVER['DOCUMENT_ROOT'] . '/scripts/uploads/' . $id . '_m.jpg');
   }

   public function Delete($id)
   {
      parent::Delete($id);
      $this->DeleteImg($id);
      global $db;
      try {
         $db->link->beginTransaction();
         $query = SQL::SimpleQuerySelect(
            $this->ToTblNm(static::ID_FLD),
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
            $this->DeleteImg($set[static::ID_FLD]);
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

function ImageWithFlagSelectSQL($table, $field)
{
   global $_image;
   return sprintf(
      "IFNULL((%s), '') as %s",
      SQL::SimpleQuerySelect(
         $_image->ToTblNm(Image::ID_FLD),
         Image::TABLE,
         new Clause(
            CCond(
               CF($table, $field),
               CF(Image::TABLE, $_image->GetFieldByName(Image::ID_FLD))
            ),
            CCond(
               CF(Image::TABLE, $_image->GetFieldByName(Image::IS_RESIZED_FLD)),
               CVS(1),
               'AND'
            )
         )
      ),
      SQL::ToPrfxNm($table, $field->GetName())
   );
}
