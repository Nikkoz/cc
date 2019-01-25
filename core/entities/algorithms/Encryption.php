<?php

namespace core\entities\algorithms;


use yii\db\ActiveRecord;

/**
 * @property string $name
 */
class Encryption extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%algorithm_encryption}}';
    }

    public static function create(string $name): self
    {
        $algorithm = new static();
        $algorithm->name = $name;

        return $algorithm;
    }

    public function edit(string $name): void
    {
        $this->name = $name;
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
        ];
    }
}