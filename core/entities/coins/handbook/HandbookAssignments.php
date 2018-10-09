<?php

namespace core\entities\coins\handbook;


use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%post_handbook_assignments}}".
 *
 * @property int $post_id
 * @property int $handbook_id
 */
class HandbookAssignments extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%post_handbook_assignments}}';
    }

    public static function create(int $handbookId): self
    {
        $assignment = new static();
        $assignment->handbook_id = $handbookId;

        return $assignment;
    }

    public function isForHandbook(int $id): bool
    {
        return $this->handbook_id == $id;
    }
}